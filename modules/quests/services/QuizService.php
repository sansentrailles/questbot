<?php

namespace app\modules\quests\services;

use yii\helpers\Url;
use app\custom\helpers\DateHelper;
use app\modules\quests\models\Task;
use app\custom\helpers\StringHelper;
use app\modules\quests\api\telegram\TelegramBot;

class QuizService
{
    private $bot;
    private $questService;
    private $taskService;
    private $userProgressService;
    private $answerService;
    private $hintService;
    private $statService;
    private $statItemService;

    public function __construct(TelegramBot $bot)
    {
        $container = \Yii::$container;
        $this->questService = $container->get(QuestService::class);
        $this->userProgressService = $container->get(UserProgressService::class);
        $this->taskService = $container->get(TaskService::class);
        $this->answerService = $container->get(AnswerService::class);
        $this->hintService = $container->get(HintService::class);
        $this->statService = $container->get(StatService::class);
        $this->statItemService = $container->get(StatItemService::class);
        $this->bot = $bot;
    }

    /**
     * Обработка входящего обновления с роутингом команд и кнопок
     */
    public function handleUpdate($update) {
        // Пропуск повторно доставленных обновлений (Telegram ретраит webhook, если не получил ответ)
        if (!$this->checkUpdateId($update)) {
            return;
        }

        // Обработка callback-запросов от inline кнопок
        if (isset($update['callback_query'])) {
            $this->handleCallbackQuery($update['callback_query']);
            return;
        }
        
        // Обработка обычных сообщений
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'] ?? '';
            
            // Обработка команд
            if (strpos($text, '/') === 0) {
                $this->handleCommand($chatId, $text);
                return;
            }

            // Сообщения без текста (фото, стикеры и т.д.) не являются ответом
            if ($text === '') {
                return;
            }
            
            // Обработка обычных сообщений
            try {
                $this->handleMessage($chatId, $text);
            } catch (\Throwable $e) {
                error_log("Error processing message: " . $e->getMessage());
                $this->sendErrorMessage($chatId);
            }
        }
    }

    /**
     * Защита от повторной обработки одного и того же обновления Telegram
     * @param array $update
     * @return bool true - обновление новое, false - уже обрабатывалось
     */
    private function checkUpdateId($update): bool
    {
        $updateId = $update['update_id'] ?? null;
        if ($updateId === null) {
            return true;
        }

        $cache = \Yii::$app->cache;
        $cacheKey = 'telegram_update_' . $updateId;
        if ($cache->get($cacheKey)) {
            return false;
        }
        $cache->set($cacheKey, true, 3600);

        return true;
    }

    /**
     * Уведомление пользователя о внутренней ошибке
     */
    private function sendErrorMessage($chatId)
    {
        try {
            $this->sendMessage($chatId, 'Произошла ошибка 😟 Попробуйте ещё раз. Если проблема повторяется, отправьте /quests');
        } catch (\Throwable $e) {
            error_log("Error sending error message: " . $e->getMessage());
        }
    }

    /**
     * Отправка сообщения с fallback: если Telegram отклонил HTML-разметку
     * ("can't parse entities"), текст очищается от тегов и отправляется без parse_mode
     */
    private function sendMessage($chatId, $text, $options = [])
    {
        try {
            return $this->bot->sendMessage($chatId, $text, $options);
        } catch (\Throwable $e) {
            if (stripos($e->getMessage(), 'can\'t parse entities') === false) {
                throw $e;
            }

            error_log("Telegram HTML parse error, retrying without parse_mode: " . $e->getMessage());
            unset($options['parse_mode']);

            return $this->bot->sendMessage($chatId, strip_tags($text), $options);
        }
    }

    /**
     * Отправка фото с fallback: если Telegram отклонил HTML-разметку подписи,
     * подпись очищается от тегов и отправляется без parse_mode
     */
    private function sendPhoto($chatId, $photo, $caption = '', $options = [])
    {
        try {
            return $this->bot->sendPhoto($chatId, $photo, $caption, $options);
        } catch (\Throwable $e) {
            if (stripos($e->getMessage(), 'can\'t parse entities') === false) {
                throw $e;
            }

            error_log("Telegram HTML parse error, retrying without parse_mode: " . $e->getMessage());
            unset($options['parse_mode']);

            return $this->bot->sendPhoto($chatId, $photo, strip_tags($caption), $options);
        }
    }
    
    /**
     * Обработка callback-запросов от inline кнопок
     * @param array $callbackQuery - данные callback-запроса
     */
    protected function handleCallbackQuery($callbackQuery) {
        $chatId = $callbackQuery['message']['chat']['id'];
        $messageId = $callbackQuery['message']['message_id'];
        $data = $callbackQuery['data'];
        $callbackQueryId = $callbackQuery['id'];
        
        try {
            // Ответим на callback (чтобы убрать "часики" у кнопки).
            // Ошибка здесь (например, "query is too old" при повторной доставке
            // обновления) не должна прерывать обработку нажатия кнопки
            try {
                $this->bot->answerCallbackQuery($callbackQueryId);
            } catch (\Throwable $e) {
                error_log("Error answering callback query: " . $e->getMessage());
            }

            // Разбираем данные кнопки (можно использовать JSON или разделители)
            $buttonData = $this->parseButtonData($data);
            // Обрабатываем действие в зависимости от данных кнопки
            switch ($buttonData['action']) {
                // Список прогулок
                case 'quests':
                    $this->showQuests($chatId);
                    break;

                // Выбор пргулки
                case 'quest_info':
                    $this->showQuestInfo($chatId, (int) $buttonData['value']);
                    break;

                // Отображение статистики
                case 'show_stat_list':
                    $this->showStatList($chatId);
                    break;
                case 'show_quest_stat':
                    $this->showQuestStat($chatId, (int) $buttonData['value']);
                    break;

                // Запуск прогулки
                case 'start_quest':
                    $this->startQuest($chatId, (int) $buttonData['value']);
                    break;

                // Отображение справки прогулки
                case 'quest_help':
                    $this->showQuestHelp($chatId, (int) $buttonData['value']);
                    break;

                // Обработка выбора ответа
                case 'task_answer':
                    list($answerId, $questId) = explode("@", $buttonData['value']);
                    $this->handleChoiceAnswer($chatId, (int) $answerId, (int) $questId);
                    break;

                // Обработка ответа, введенного пользователем
                case 'apply_answer':
                    $this->handleInputAnswer($chatId, $buttonData['value']);
                    break;

                // Перейти к заданию из подсказки
                case 'to_task':
                    $this->sendNextTask($chatId, (int) $buttonData['value']);
                    break;

                // Открыть следующие задание послие инфомрационного сообщения текущего выполненного задания
                case 'next_task':
                    $this->sendNextTaskAfterShowMessage($chatId, (int) $buttonData['value']);
                    break;

                // Показать подсказку
                case 'show_hint':
                    $this->handleHint($chatId, (int) $buttonData['value']);
                    break;

                case 'task_show_place':
                    $this->showPlaceForTask($chatId, (int) $buttonData['value']);
                    break;

                default:
                    $this->sendMessage($chatId, 'Неизвестное действие кнопки 😟 Отправьте /quests для начала работы');
            }
            
        } catch (\Throwable $e) {
            error_log("Error processing callback: " . $e->getMessage());
            $this->sendErrorMessage($chatId);
        }
    }
    
    /**
     * Парсинг данных кнопки (можно переопределить в дочернем классе)
     * @param string $data - данные кнопки (callback_data)
     * @return array - распарсенные данные
     */
    protected function parseButtonData($data) {
        // Простой пример: action:value
        $parts = explode(':', $data, 2);
        
        return [
            'action' => $parts[0] ?? 'unknown',
            'value' => $parts[1] ?? ''
        ];
    }

    /**
     * Обработка команд
     * @param int $chatId - ID чата
     * @param string $command - команда (например, "/start")
     */
    protected function handleCommand($chatId, $command) {
        // Нормализация: "/start@BotName arg" -> "/start"
        $parts = explode(' ', trim($command));
        $command = strtolower(explode('@', $parts[0])[0]);

        switch ($command) {
            case '/start':
                $this->sendStartMessage($chatId);
                break;
            case '/quests':
                $this->showQuests($chatId);
                break;
                
            default:
                $this->sendMessage($chatId, "Неизвестная команда: $command");
        }
    }

    protected function sendStartMessage($chatId) {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Прогулки 🚶‍♂️', 'callback_data' => 'quests'],
                    ['text' => 'Статистика 📊', 'callback_data' => 'show_stat_list']
                ],
            ]
        ];
        
        $this->sendMessage($chatId, "Добро пожаловать! Выберите действие:", [
            'reply_markup' => json_encode($keyboard)
        ]);
    }
    
    /**
     * TODO: Вынести обработку ответа в отдельный метод
     * Обработка обычных сообщений (можно переопределить в дочернем классе)
     * @param int $chatId - ID чата
     * @param string $text - текст сообщения
     */
    protected function handleMessage($chatId, $text)
    {
        $progress = $this->userProgressService->getProgress($chatId);
        if ($progress) {
            
            $progress->answer = $text;
            $this->userProgressService->updateProgress($progress);

            $message =  "Ваш ответ: \n". $text."\n\nНажмите \"Принять ✅\" для подтверждения или введите новый ответ";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Принять ✅', 'callback_data' => 'apply_answer:'.$progress->current_task_id],
                    ],
                ]
            ];
            
            $this->sendMessage($chatId, $message, [
                'reply_markup' => json_encode($keyboard),
                'parse_mode' => 'html'
            ]);
        }

        // $this->sendMessage($chatId, "Вы написали: $text");
    }
    
    private function showQuests($chatId)
    {
        // Если есть прогулка в процессе, показываем следующее задание этой прогулки
        $progress = $this->userProgressService->getProgress($chatId);
        if ($progress) {
            $this->sendMessage($chatId, "Вы находитесь на прогулке:\n" . $progress->quest->title. "\n\nАктуальное задание" );
            return $this->sendNextTask($chatId, $progress->quest_id);
        }

        $quests = $this->questService->getVisible();
        if (count($quests) > 0) {
            $keyboard = $this->questService->generateQuestKeyboard($quests);

            $message = StringHelper::escapeMarkdown("Вас приветствует бот городских прогулок-викторин!\n\nСписок доступных прогулок:");
            return $this->sendMessage($chatId, $message, [
                'reply_markup' => json_encode($keyboard),
                'parse_mode' => 'html'
            ]);
        } else {
            return $this->sendMessage($chatId, 'В данный момент нет активных прогулок 😟');
        }
    }

    /**
     * Отобразить информацию прогулки, описания и кнопки: Начать прогулку и Справка / Рекомендации
     * @param mixed $chatId
     * @param int $questId
     * @return array
     */
    protected function showQuestInfo($chatId, int $questId)
    {
        $quest = $this->questService->find($questId);
        if ($quest == null) {
            return $this->sendMessage($chatId, 'К сожалению прогулка не найдена или неактивна 😟');
        }


        $inlineKeyboards = [];
        $helpButton = ['text' => 'Справка / Рекомендации ℹ️', 'callback_data' => 'quest_help:'.$quest->id];
        $startButton = ['text' => 'Начать прогулку ▶️', 'callback_data' => 'start_quest:'.$quest->id];

        if ($quest->help) {
            $inlineKeyboards[] = [$helpButton];
        }

        $inlineKeyboards[] = [$startButton];

        $keyboard = [
            'inline_keyboard' => $inlineKeyboards,
        ];

        $message = $quest->desc;

        if ($quest->image) {
            return $this->sendPhoto($chatId, $quest->imageFullPath, $message, [
                'reply_markup' => json_encode($keyboard),
                'parse_mode' => 'html',
            ]);
        }

        return $this->sendMessage($chatId, $message, [
            'reply_markup' => json_encode($keyboard),
            'parse_mode' => 'html',
        ]);
    }

    protected function showQuestHelp($chatId, int $questId)
    {
        $quest = $this->questService->find((int) $questId);
        if ($quest == null) {
            return $this->sendMessage($chatId, 'К сожалению, данная прогулка не найдена или неактивна 😟');
        }

        $message = $quest->help;
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Начать прогулку ▶️', 'callback_data' => 'start_quest:'.$quest->id],
                ],
            ]
        ];

        return $this->sendMessage($chatId, $message, [
            'reply_markup' => json_encode($keyboard),
            'parse_mode' => 'html',
        ]);
    }

    protected function startQuest($chatId, int $questId)
    {
        $quest = $this->questService->find($questId);
        if ($quest == null) {
            return $this->sendMessage($chatId, 'К сожалению данная прогулка не найдена или неактивна 😟');
        }

        $tasks = $quest->visibleTasks;
        if (count($tasks) == 0) {
            return $this->sendMessage($chatId, 'К сожалению данная прогулка не содержит заданий 😟');
        }

        $this->userProgressService->createProgress($chatId, $questId, $tasks[0]->id);
        $this->statService->createStat($chatId, $questId);

        $this->sendNextTask($chatId, $questId);
    }

    private function sendNextTask($chatId, $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        if ($progress == null) {
            return $this->sendMessage($chatId, 'Прогулка не найдена или уже завершена. Отправьте /quests, чтобы начать новую.');
        }

        $currentTask = $progress->task;

        return $this->showTask($chatId, $currentTask, $progress);

        // $nextTask = $this->taskService->getNext($currentTask);
        // Обновить прогресс
        // Показать следующий вопрос
        // Если следующего вопрос нет - показать информацию об окончании прогулки,
        // установить UserProgress::is_complete = true
    }

    // Показать задание
    private function showTask($chatId, $task, $progress)
    {
        $message = $task->question;

        // Формирование вариантов ответов, если вопрос с выбором варианта
        $keyboard = [];
        $hints = $task->visibleHints;
        $hintsCount = count($hints);

        if ($task->type == Task::TYPE_CHOICE) {
            $answers = $task->answers;
            shuffle($answers);

            foreach ($answers as $key => $answer) {
                $keyboard[] = [
                    [
                        'text' => StringHelper::numberToEmojiDigits($key + 1).' '. $answer->title,
                        'callback_data' => 'task_answer:' . $answer->id.'@'.$task->quest_id
                    ]
                ];
            }
        } else {
            $message .= "\n\nНапишите ответ в поле ввода сообщения: ";
        }

        // TODO: refactor it
        if ($hintsCount > 0) {
            if ($progress->hint_used == $hintsCount) {
                $keyboard[] = [
                    [
                        'text' => 'Посмотреть место 🌐',
                        'callback_data' => 'task_show_place:'.$task->id
                    ]
                ];
            } else {
                $keyboard[] = [
                    [
                        'text' => 'Подсказки ('.(int) $progress->hint_used.'/'.$hintsCount.') ℹ️',
                        'callback_data' => 'show_hint:' . $task->quest_id,
                    ]
                ];
            }
        }

        $options = [];
        if (count ($keyboard) > 0) {
            $replyMarkup = [
                'inline_keyboard' => $keyboard
            ];

            $options['reply_markup'] = json_encode($replyMarkup);
            $options['parse_mode'] = 'html';
        }

        $stat = $this->statService->getActualStat($chatId, $progress->quest_id);
        if ($stat) {
            $this->statItemService->saveItem($stat->id, $task, null, false);
        }

        if ($task->image) {
            return $this->sendPhoto($chatId, $task->imageFullPath, $message, $options);
        }

        return $this->sendMessage($chatId, $message, $options);
    }

    public function showPlaceForTask($chatId, $taskId)
    {
        $task = $this->taskService->find((int) $taskId);
        if ($task === null) {
            return $this->sendMessage($chatId, 'К сожалению, данное задание не найдено 😟');
        }

        if ($task->place_show == Task::PLACE_NOT_SHOW) {
            return;
        }

        $message = "Место: ".$task->place."\n";
        $message .= "Адрес: ".$task->address."\n";

        $options = [];
        $options['parse_mode'] = 'html';

        $this->sendMessage($chatId, $message, $options);
    }

    // Обработка выбора ответа
    protected function handleChoiceAnswer($chatId, int $answerId, int $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        if ($progress == null) {
            return $this->sendMessage($chatId, 'Прогулка не найдена или уже завершена. Отправьте /quests, чтобы начать новую.');
        }

        $currentTask = $progress->task;
        $stat = $this->statService->getActualStat($chatId, $questId);

        $answer = $this->answerService->find($answerId);
        if ($answer == null) {
            return $this->sendMessage($chatId, 'К сожалению, данный вариант ответа не найден 😟');
        }

        if ($stat) {
            $this->saveChoicedAnswer($stat, $currentTask, $answer);
        }

        if ($currentTask->message && mb_strlen($currentTask->message) > 0) {
            return $this->sendMessageAfterAnswer($chatId, $currentTask);
        } else {
            $this->handleNextAnswer($chatId, $currentTask, $progress);
        }
    }

    public function handleInputAnswer($chatId, $taskId)
    {
        $progress = $this->userProgressService->getProgress($chatId);
        if ($progress == null) {
            return $this->sendMessage($chatId, 'Прогулка не найдена или уже завершена. Отправьте /quests, чтобы начать новую.');
        }

        $stat = $this->statService->getActualStat($chatId, $progress->quest_id);
        $currentTask = $progress->task;

        if ($stat) {
            $this->saveInputedAnswer($stat, $currentTask, $progress->answer);
        }

        if ($currentTask->message && mb_strlen($currentTask->message) > 0) {
            return $this->sendMessageAfterAnswer($chatId, $currentTask);
        } else {
            $this->handleNextAnswer($chatId, $currentTask, $progress);
        }
    }

    private function handleNextAnswer($chatId, $currentTask, $progress)
    {
        $nextTask = $this->taskService->getNext($currentTask);
        if ($nextTask) {
            $progress->current_task_id = $nextTask->id;
            $progress->answer = null;
            $progress->hint_id = null;
            $progress->hint_used = null;
            $this->userProgressService->updateProgress($progress);
            $this->sendNextTask($chatId, $progress->quest_id);
        } else {
            $this->finalizeQuiz($chatId, $progress);

            $stat = $this->statService->getActualStat($chatId, $progress->quest_id);
            if ($stat) {
                $this->statService->finishStat($stat);
            }
        }
    }

    // Показать инофрмацию задания после ответа
    public function sendMessageAfterAnswer($chatId, $currentTask)
    {
        $keyboard[] = [
            [
                'text' => "Дальше ➡️",
                'callback_data' => 'next_task:' . $currentTask->id
            ]
        ];

        $message = $currentTask->message;
        $message .= "\n\n Нажмите кнопку \"Дальше  ➡️\" для продолжения";

        $replyMarkup = [
            'inline_keyboard' => $keyboard
        ];

        if ($currentTask->image_info) {
            return $this->sendPhoto($chatId, $currentTask->imageInfoFullPath, $message, [
                // 'show_caption_above_media' => true,
                'parse_mode' => 'html',
                'reply_markup' => json_encode($replyMarkup),
            ]);
        }

        return $this->sendMessage($chatId, $message, [
            'parse_mode' => 'html',
            'reply_markup' => json_encode($replyMarkup),
        ]);
    }

    // Обработать следующее задание квеста после отображения информации, котороая отображается после ответа
    private function sendNextTaskAfterShowMessage($chatId, $taskId)
    {
        $currentTask = $this->taskService->find((int) $taskId);
        if ($currentTask == null)  {
            return $this->sendMessage($chatId, 'К сожалению, данное задание не найдено 😟 (Ошибка 1-10)');
        }

        $progress = $this->userProgressService->getProgress($chatId);
        if ($progress == null) {
            return $this->sendMessage($chatId, 'Прогулка не найдена или уже завершена. Отправьте /quests, чтобы начать новую.');
        }

        $this->handleNextAnswer($chatId, $currentTask, $progress);
    }

    private function saveChoicedAnswer($stat, $task, $answer)
    {
        $this->statItemService->saveItem($stat->id, $task, $answer->title, (bool) $answer->is_right);
    }

    private function saveInputedAnswer($stat, $task, $answer)
    {
        $isCorrect = false;
        if (mb_strtolower($answer) == mb_strtolower($task->answer)) {
            $isCorrect = true;
        }

        $this->statItemService->saveItem($stat->id, $task, $answer, $isCorrect);
    }

    private function finalizeQuiz($chatId, $progress)
    {
        $quest = $progress->quest;
        $this->userProgressService->completeQuest($progress);

        $message = "Все задания прогулки заданы!\n\n<b>Спасибо за участие!</b>";
        if ($quest->text_final) {
            $message = $quest->text_final;
        }

        $options = ['parse_mode' => 'html'];
        $stat = $this->statService->getActualStat($chatId, $progress->quest_id);
        if ($stat) {
            $options['reply_markup'] = json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => "Показать статистику 📊",
                            'callback_data' => 'show_quest_stat:'.$stat->id,
                        ]
                    ]
                ]
            ]);
        }

        if ($quest->image_final) {
            return $this->sendPhoto($chatId, $quest->imageFinalFullPath, $message, $options);
        }

        return $this->sendMessage($chatId, $message, $options);
    }

    private function handleHint($chatId, $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        if ($progress == null) {
            return $this->sendMessage($chatId, 'Прогулка не найдена или уже завершена. Отправьте /quests, чтобы начать новую.');
        }

        $currentTask = $progress->task;
        $hints = $currentTask->visibleHints;
        $stat = $this->statService->getActualStat($chatId, $progress->quest_id);

        if (count($hints) == 0) {
            return $this->sendMessage($chatId, "Подсказки не найдены ❌");
        }

        $currentHint = $progress->hint;
        if ($currentHint === null) {
            $nextHint = $hints[0];
        }  else {
            $nextHint = $this->hintService->getNext($currentHint);
        }

        if ($nextHint) {
            $progress->hint_id = $nextHint->id;
            $progress->hint_used = (int) $progress->hint_used + 1;
            $this->userProgressService->updateProgress($progress);
            $this->showHint($chatId, $nextHint, $progress);
            if ($stat) {
                $this->statItemService->incrementHints($stat->id, $progress->current_task_id);
            }
        // } else {
        //     // Вроде бы этот код не нужен
        //     $this->sendNextTask($chatId, $questId);
        }
    }

    // Показать подксказку
    private function showHint($chatId, $hint, $progress)
    {
        $task = $progress->task;

        $hints = $task->visibleHints;
        $hintsCount = count($hints);

        $firstButton = [
            'text' => 'Подсказки ('.(int) $progress->hint_used.'/'.$hintsCount.') ℹ️ ',
            'callback_data' => 'show_hint:' . $task->quest_id,
        ];

        // Если последняя подсказка, показать кнопку "Показать место"
        if ($progress->hint_used == $hintsCount) {
            $firstButton = [
                'text' => 'Посмотреть место 🌐',
                'callback_data' => 'task_show_place:'.$task->id
            ];
        }

        $keyboard[] = [
            $firstButton,
            [
                'text' => 'Вернуться к вопросу ⬅️',
                'callback_data' => 'to_task:' . $task->quest_id,
            ]
        ];

        $replyMarkup = [];
        if (count ($keyboard) > 0) {
            $replyMarkup = [
                'inline_keyboard' => $keyboard
            ];
        }

        $message = "<b>Подсказка:</b>\n".$hint->text;
        if ($hint->image) {
            return $this->sendPhoto($chatId, $hint->imageFullPath, $message, [
                'show_caption_above_media' => true,
                'parse_mode' => 'html',
                'reply_markup' => json_encode($replyMarkup),
            ]);
        }

        return $this->sendMessage($chatId, $message, [
            'parse_mode' => 'html',
            'reply_markup' => json_encode($replyMarkup),
        ]);
    }

    private function showStatList($chatId)
    {
        return $this->sendMessage($chatId, 'Скоро будет статистика');
    }

    private function showQuestStat($chatId, $statId)
    {
        $stat = $this->statService->find($statId);
        if ($stat == null) {
            return $this->sendMessage($chatId, 'Статистика не найдена 😟 (Ошибка 1-11)');
        }

        $quest = $stat->quest;
        $items = $stat->items;

        $message = "Статистика по прогулке:\n <b>{$quest->title}</b>\n\n";
        $message .= "<b>Начало:</b> " . DateHelper::formatTimestampRu($stat->start)."\n";
        $message .= "<b>Завершение:</b> " . DateHelper::formatTimestampRu($stat->finish)."\n";
        $message .= "<b>Продолжительность:</b> " . DateHelper::formatTimeDiffImproved((int) $stat->start, (int) $stat->finish)."\n";
        $message .= "<b>Количество точек:</b> ". count($items);
        $message .= "\n\nНажмите кнопку \"Подробная статистика ↗️\", чтобы открыть страницу с подробной статистикой прохождения прогулки";

        $link = Url::to(['/quests/default/stat', 'uuid' => $stat->uuid], true);

        $keyboard[] = [
            [
                'text' => 'Подробная статистика ↗️',
                'url' => $link
            ]
        ];

        $replyMarkup = [
            'inline_keyboard' => $keyboard
        ];

        $this->sendMessage($chatId, $message, [
            'parse_mode' => 'html',
            'reply_markup' => json_encode($replyMarkup),
        ]);
    }
}