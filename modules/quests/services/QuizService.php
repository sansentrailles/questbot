<?php

namespace app\modules\quests\services;

use app\modules\quests\models\Task;
use app\modules\quests\api\telegram\TelegramBot;

class QuizService
{
    private $bot;
    private $questService;
    private $taskService;
    private $userProgressService;
    private $answerService;

    public function __construct(TelegramBot $bot)
    {
        $container = \Yii::$container;
        $this->questService = $container->get(QuestService::class);
        $this->userProgressService = $container->get(UserProgressService::class);
        $this->taskService = $container->get(TaskService::class);
        $this->answerService = $container->get(AnswerService::class);
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
            
            error_log("Handle update");
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
        error_log("ButtonData ".print_r($buttonData, true));
            // Обрабатываем действие в зависимости от данных кнопки
            switch ($buttonData['action']) {
                case 'show_text':
                    $this->bot->sendMessage($chatId, "Вы нажали кнопку: {$buttonData['value']}");
                    break;

                case 'show_quest':
                    $this->showQuestInfo($chatId, (int) $buttonData['value']);
                    break;

                case 'start_quest':
                    $this->startQuest($chatId, (int) $buttonData['value']);
                    break;

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
                    
                case 'delete_message':
                    $this->bot->deleteMessage($chatId, $messageId);
                    break;
                    
                case 'edit_message':
                    $this->bot->editMessageText($chatId, $messageId, "Сообщение изменено!");
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
                
            case '/menu':
                $this->sendMenu($chatId);
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
    protected function sendStartMessage($chatId) {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Кнопка 1', 'callback_data' => 'show_text:Button1'],
                    ['text' => 'Кнопка 2', 'callback_data' => 'show_text:Button2']
                ],
                [
                    ['text' => 'Удалить это сообщение', 'callback_data' => 'delete_message']
                ]
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
     * Обработка обычных сообщений (можно переопределить в дочернем классе)
     * @param int $chatId - ID чата
     * @param string $text - текст сообщения
     */
    protected function handleMessage($chatId, $text)
    {
        error_log("Handle Message");

        $progress = $this->userProgressService->getProgress($chatId);
        if ($progress) {
            error_log("Progress");
            $this->bot->sendMessage($chatId, $progress->task->question);

            $message =  'Ваш ответ: \n'. $text.'\n\nНажмите "Принять ✅" для подтверждения или введите новый ответ';
            $payload = [
                'task_id' => $progress->quest_id,
                'answer' => $text,
            ];
            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Принять ✅', 'callback_data' => "apply_answer:".json_encode($payload)],
                    ],
                ]
            ];
            
            $this->bot->sendMessage($chatId, $message, [
                'reply_markup' => json_encode($keyboard)
            ]);
            
            // $payload = [
            //     'task_id' => $progress->quest_id,
            //     'answer' => $text,
            // ];

            // $keyboard = [
            //     'inline_keyboard' => [
            //         [
            //             ['text' => 'Принять ✅', 'callback_data' => 'apply_answer:'.json_encode($payload)],
            //         ],
            //     ]
            // ];
            
            // $message =  'Ваш ответ: '. $text.'\n\nНажмите "Принять ✅" для подтверждения или введите новый ответ';
            // $this->bot->sendMessage($chatId, $message, [
            //     'reply_markup' => json_encode($keyboard)
            // ]);
        }

        $this->bot->sendMessage($chatId, "Вы написали: $text");
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

            return $this->bot->sendMessage($chatId, "Вас приветствует бот городских прогулок-викторин! Список доступных прогулок:", [
                'reply_markup' => json_encode($keyboard),
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
        error_log("Start quest");
        $quest = $this->questService->find($questId);
        if ($quest == null) {
            return $this->bot->sendMessage($chatId, 'К сожалению данная прогулка не найдена или неактивна 😟');
        }

        $tasks = $quest->visibleTasks;
        if (count($tasks) == 0) {
            return $this->bot->sendMessage($chatId, 'К сожалению данная прогулка не содержит заданий 😟');
        }

        $this->userProgressService->createProgress($chatId, $questId, $tasks[0]->id);

        $this->sendNextTask($chatId, $questId);

        // $progress = $this->userProgressService->getProgress($chatId, $questId);
    }

    private function sendNextTask($chatId, $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        $currentTask = $progress->task;

        return $this->showTask($chatId, $currentTask);

        // $nextTask = $this->taskService->getNext($currentTask);
        // Обновить прогресс
        // Показать следующий вопрос
        // Если следующего вопрос нет - показать информацию об окончании прогулки,
        // установить UserProgress::is_complete = true
    }

    private function showTask($chatId, $task)
    {
        $message = $task->question;

        // Формирование вариантов ответов, если вопрос с выбором варианта
        $keyboard = [];
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

            $replyMarkup = [
                'inline_keyboard' => $keyboard
            ];
        } else {
            $message .= "\n\nВведите ответ на вопрос: ";
        }

        $options = [];
        if (count ($keyboard) > 0) {
            $options['reply_markup'] = json_encode($replyMarkup);
        }

        if ($task->image) {
            return $this->bot->sendPhoto($chatId, $task->imageFullPath, $message, $options);
        }

        return $this->bot->sendMessage($chatId, $message, $options);
    }

    protected function handleChoiceAnswer($chatId, int $answerId, int $questId)
    {
        $progress = $this->userProgressService->getProgress($chatId, $questId);
        $currentTask = $progress->task;

        $answer = $this->answerService->find($answerId);
        // Сделать проверку выбора правильного ответа
        // сохранить прогресс

        $nextTask = $this->taskService->getNext($currentTask);
        if ($nextTask) {
            $this->userProgressService->updateProgress($progress, $nextTask->id);
            $this->sendNextTask($chatId, $questId);
        } else {
            $this->userProgressService->completeQuest($progress);
            $this->bot->sendMessage($chatId, "Все задания выполнены! Спасибо за участие!");
        }
    }

    public function handleInputAnswer($chatId, $payload)
    {
        return $this->bot->sendMessage($chatId, "Payload\n".print_r($payload));
    }
}