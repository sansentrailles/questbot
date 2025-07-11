<?php

namespace app\modules\quests\services;

use app\custom\helpers\StringHelper;
use app\modules\quests\models\Task;
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
            
            // Обработка обычных сообщений
            $this->handleMessage($chatId, $text);
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
            // Ответим на callback (чтобы убрать "часики" у кнопки)
            $this->bot->answerCallbackQuery($callbackQueryId);
            
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
                case 'show_stat':
                    $this->showStat($chatId);
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

                // Показать подсказку
                case 'show_hint':
                    $this->handleHint($chatId, (int) $buttonData['value']);
                    break;

                case 'task_show_place':
                    $this->showPlaceForTask($chatId, (int) $buttonData['value']);
                    break;

                default:
                    $this->processCustomButtonAction($chatId, $messageId, $buttonData);
            }
            
        } catch (\Exception $e) {
            error_log("Error processing callback: " . $e->getMessage());
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
     * Обработка команд (можно переопределить в дочернем классе)
     * @param int $chatId - ID чата
     * @param string $command - команда (например, "/start")
     */
    protected function handleCommand($chatId, $command) {
        switch ($command) {
            case '/start':
                $this->sendStartMessage($chatId);
                break;
            case '/quests':
                $this->showQuests($chatId);
                break;
                
            default:
                $this->bot->sendMessage($chatId, "Неизвестная команда: $command");
        }
    }
    
    /**
     * Отправка стартового сообщения
     * @param int $chatId - ID чата
     */
    // protected function sendStartMessage($chatId) {
    //     $keyboard = [
    //         'inline_keyboard' => [
    //             [
    //                 ['text' => 'Кнопка 1', 'callback_data' => 'show_text:Button1'],
    //                 ['text' => 'Кнопка 2', 'callback_data' => 'show_text:Button2']
    //             ],
    //             [
    //                 ['text' => 'Удалить это сообщение', 'callback_data' => 'delete_message']
    //             ]
    //         ]
    //     ];
        
    //     $this->bot->sendMessage($chatId, "Добро пожаловать! Выберите действие:", [
    //         'reply_markup' => json_encode($keyboard)
    //     ]);
    // }

    protected function sendStartMessage($chatId) {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Прогулки 🚶‍♂️', 'callback_data' => 'quests'],
                    ['text' => 'Статистика 📊', 'callback_data' => 'show_stat']
                ],
            ]
        ];
        
        $this->bot->sendMessage($chatId, "Добро пожаловать! Выберите действие:", [
            'reply_markup' => json_encode($keyboard)
        ]);
    }
    
    /**
     * Отправка меню
     * @param int $chatId - ID чата
     */
    protected function sendMenu($chatId) {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Информация', 'callback_data' => 'menu:info'],
                    ['text' => 'Настройки', 'callback_data' => 'menu:settings']
                ],
                [
                    ['text' => 'Помощь', 'callback_data' => 'menu:help'],
                    ['text' => 'Закрыть', 'callback_data' => 'menu:close']
                ]
            ]
        ];
        
        $this->bot->sendMessage($chatId, "Главное меню:", [
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
            // $this->statService->getActualStat($chatId, $progress->quest_id);

            $message =  "Ваш ответ: \n". $text."\n\nНажмите \"Принять ✅\" для подтверждения или введите новый ответ";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Принять ✅', 'callback_data' => 'apply_answer:'.$progress->current_task_id],
                    ],
                ]
            ];
            
            $this->bot->sendMessage($chatId, $message, [
                'reply_markup' => json_encode($keyboard),
                'parse_mode' => 'HTML'
            ]);
        }

        // $this->bot->sendMessage($chatId, "Вы написали: $text");
    }
    
    /**
     * Обработка пользовательских действий кнопок (можно переопределить)
     * @param int $chatId - ID чата
     * @param int $messageId - ID сообщения
     * @param array $buttonData - данные кнопки
     */
    protected function processCustomButtonAction($chatId, $messageId, $buttonData) {
        // Пример обработки меню
        if ($buttonData['action'] === 'menu') {
            switch ($buttonData['value']) {
                case 'info':
                    $this->bot->sendMessage($chatId, "Это информационное сообщение.");
                    break;
                    
                case 'settings':
                    $this->bot->sendMessage($chatId, "Настройки бота...");
                    break;
                    
                case 'help':
                    $this->bot->sendMessage($chatId, "Помощь по боту...");
                    break;
                    
                case 'close':
                    $this->bot->deleteMessage($chatId, $messageId);
                    break;
            }
        }
    }

    private function showQuests($chatId)
    {
        // Если есть прогулка в процессе, показываем следующее задание этой прогулки
        $progress = $this->userProgressService->getProgress($chatId);
        if ($progress) {
            $this->bot->sendMessage($chatId, "Вы находитесь на прогулке: " . $progress->quest->title. "\nАктуальное задание" );
            return $this->sendNextTask($chatId, $progress->quest_id);
        }

        $quests = $this->questService->getVisible();
        if (count($quests) > 0) {
            $keyboard = $this->questService->generateQuestKeyboard($quests);

            $message = StringHelper::escapeMarkdown("Вас приветствует бот городских прогулок-викторин!\n\nСписок доступных прогулок:");
            return $this->bot->sendMessage($chatId, $message, [
                'reply_markup' => json_encode($keyboard),
                'parse_mode' => 'markdownv2'
            ]);
        } else {
            return $this->bot->sendMessage($chatId, 'В данный момент нет активных прогулок 😟');
        }
    }

    protected function showQuestInfo($chatId, int $questId)
    {
        $quest = $this->questService->find((int) $questId);
        if ($quest == null) {
            return $this->bot->sendMessage($chatId, 'К сожалению прогулка не найдена или неактивна 😟');
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
        // $keyboard = [
        //     'inline_keyboard' => [
        //         [
        //             ['text' => 'Начать прогулку ▶️', 'callback_data' => 'start_quest:'.$quest->id],
        //         ],
        //     ]
        // ];

        if ($quest->image) {
            return $this->bot->sendPhoto($chatId, $quest->imageFullPath, $message, [
                'reply_markup' => json_encode($keyboard),
                'parse_mode' => 'html',
            ]);
        }

        return $this->bot->sendMessage($chatId, $message, [
            'reply_markup' => json_encode($keyboard),
            'parse_mode' => 'html',
        ]);
    }

    protected function showQuestHelp($chatId, int $questId)
    {
        $quest = $this->questService->find($questId);
        if ($quest == null) {
            return $this->bot->sendMessage($chatId, 'К сожалению, данная прогулка не найдена или неактивна 😟');
        }

        $message = $quest->help;
        // $message = StringHelper::escapeMarkdown($quest->help);
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Начать прогулку ▶️', 'callback_data' => 'start_quest:'.$quest->id],
                ],
            ]
        ];

        return $this->bot->sendMessage($chatId, $message, [
            'reply_markup' => json_encode($keyboard),
            'parse_mode' => 'html',
        ]);
    }

    protected function startQuest($chatId, int $questId)
    {
        $quest = $this->questService->find($questId);
        if ($quest == null) {
            return $this->bot->sendMessage($chatId, 'К сожалению данная прогулка не найдена или неактивна 😟');
        }

        $tasks = $quest->visibleTasks;
        if (count($tasks) == 0) {
            return $this->bot->sendMessage($chatId, 'К сожалению данная прогулка не содержит заданий 😟');
        }

        $progress = $this->userProgressService->createProgress($chatId, $questId, $tasks[0]->id);
        $stat = $this->statService->createStat($chatId, $questId);

        $this->sendNextTask($chatId, $questId);

        // $progress = $this->userProgressService->getProgress($chatId, $questId);
    }

    private function sendNextTask($chatId, $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
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

        $kbButton = [];
        if ($task->place_show == Task::PLACE_SHOW) {
            // $message .= "\n\nМесто: ".$task->place."\n";
            // $message .= "Адрес: ".$task->address."\n";
            // $baseUrl = "https://yandex.ru/maps/"; 
            // $link = "{$baseUrl}?ll={$task->longitude}%2C{$task->latitude}&z=17";
            $kbButton = [
                [
                    'text' => 'Посмотреть место',
                    'callback_data' => 'task_show_place:'.$task->id
                ]
            ];
        }

        // Формирование вариантов ответов, если вопрос с выбором варианта
        $keyboard = [];
        $hints = $task->visibleHints;
        $hintsCount = count($hints);

        if ($task->type == Task::TYPE_CHOICE) {
            $answers = $task->answers;

            foreach ($answers as $answer) {
                $keyboard[] = [
                    [
                        'text' => $answer->title,
                        'callback_data' => 'task_answer:' . $answer->id.'@'.$task->quest_id
                    ]
                ];
            }
        } else {
            $message .= "\n\nВведите ответ на вопрос: ";
        }

        if ($hintsCount > 0) {
            $keyboard[] = [
                [
                    'text' => 'Подсказки ('.(int) $progress->hint_used.'/'.$hintsCount.') ℹ️',
                    'callback_data' => 'show_hint:' . $task->quest_id,
                ]
            ];
        }

        if (count($kbButton) > 0) {
            $keyboard[] = $kbButton;
        }

        $options = [];
        if (count ($keyboard) > 0) {
            $replyMarkup = [
                'inline_keyboard' => $keyboard
            ];

            $options['reply_markup'] = json_encode($replyMarkup);
            $options['parse_mode'] = 'html';
        }
        if ($task->image) {
            return $this->bot->sendPhoto($chatId, $task->imageFullPath, $message, $options);
        }

        return $this->bot->sendMessage($chatId, $message, $options);
    }

    public function showPlaceForTask($chatId, $taskId)
    {
        $task = $this->taskService->find((int) $taskId);
        if ($task === null) {
            $this->bot->sendMessage($chatId, 'К сожалению, данное задание не найдено 😟');
        }

        if ($task->place_show == Task::PLACE_NOT_SHOW) {
            return;
        }

        $message = "Задание: ".$task->question."\n\n";
        $message .= "Место: ".$task->place."\n";
        $message .= "Адрес: ".$task->address."\n";

        $baseUrl = "https://yandex.ru/maps/"; 
        $link = "{$baseUrl}?ll={$task->longitude}%2C{$task->latitude}&z=17";
        $kbButton = [
            [
                'text' => 'Посмотреть на карте 🌐',
                'url' => $link
            ]
        ];

        $keyboard[] = $kbButton;

        $options = [];
        if (count ($keyboard) > 0) {
            $replyMarkup = [
                'inline_keyboard' => $keyboard
            ];

            $options['reply_markup'] = json_encode($replyMarkup);
            $options['parse_mode'] = 'markdown';
        }

        $this->bot->sendMessage($chatId, $message, $options);
    }

    // Обработка выбора ответа
    protected function handleChoiceAnswer($chatId, int $answerId, int $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        // $stat = $this->statService->getStat($chatId, $questId);
        $stat = $this->statService->getActualStat($chatId, $questId);
        $currentTask = $progress->task;

        $answer = $this->answerService->find($answerId);
        if ($stat) {
            $this->saveChoicedAnswer($stat, $currentTask, $answer);
        }
        
        // Сделать проверку выбора правильного ответа
        // сохранить прогресс

        $this->handleNextAnswer($chatId, $currentTask, $progress);
    }

    public function handleInputAnswer($chatId, $taskId)
    {
        $progress = $this->userProgressService->getProgress($chatId);
        // $stat = $this->statService->getStat($chatId, $progress->quest_id);
        $stat = $this->statService->getActualStat($chatId, $progress->quest_id);
        $currentTask = $progress->task;

        if ($stat) {
            $this->saveInputedAnswer($stat, $currentTask, $progress->answer);
        }

        $this->handleNextAnswer($chatId, $currentTask, $progress);
    }

    private function handleNextAnswer($chatId, $currentTask, $progress)
    {
        $nextTask = $this->taskService->getNext($currentTask);
        $stat = $this->statService->getStat($chatId, $progress->quest_id);
        if ($nextTask) {
            $progress->current_task_id = $nextTask->id;
            $progress->answer = null;
            $progress->hint_id = null;
            $progress->hint_used = null;
            $this->userProgressService->updateProgress($progress);
            $this->sendNextTask($chatId, $progress->quest_id);
        } else {
            $this->finalizeQuiz($chatId, $progress);
            $this->statService->finishStat($stat);
        }
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

        if ($quest->image_final) {
            return $this->bot->sendPhoto($chatId, $quest->imageFinalFullPath, $message, [
                'parse_mode' => 'html',
            ]);
        }

        return $this->bot->sendMessage($chatId, $message, [
            'parse_mode' => 'html',
        ]);
    }

    private function handleHint($chatId, $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        $currentTask = $progress->task;
        $hints = $currentTask->visibleHints;
        $stat = $this->statService->getActualStat($chatId, $progress->quest_id);

        if (count($hints) == 0) {
            return $this->bot->sendMessage($chatId, "Подсказки не найдены ❌");
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
            $this->statItemService->incrementHints($stat->id, $progress->task_id);
        } else {
            // Вроде бы этот код не нужен
            $this->sendNextTask($chatId, $questId);
        }
    }

    private function showHint($chatId, $hint, $progress)
    {
        $task = $progress->task;

        $hints = $task->visibleHints;
        $hintsCount = count($hints);
        $keyboard[] = [
            [
                'text' => 'Подсказки ('.(int) $progress->hint_used.'/'.$hintsCount.') ℹ️ ',
                'callback_data' => 'show_hint:' . $task->quest_id,
            ],
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

        $message = "**Держите подсказку:**\n\n".StringHelper::escapeMarkdown($hint->text);
        if ($hint->image) {
            return $this->bot->sendPhoto($chatId, $hint->imageFullPath, $message, [
                'show_caption_above_media' => true,
                'parse_mode' => 'markdownv2',
                'reply_markup' => json_encode($replyMarkup),
            ]);
        }

        return $this->bot->sendMessage($chatId, $message, [
            'parse_mode' => 'markdownv2',
            'reply_markup' => json_encode($replyMarkup),
        ]);
    }

    private function showStat($chatId)
    {
        return $this->bot->sendMessage($chatId, 'Скоро будет статистика');
    }
}