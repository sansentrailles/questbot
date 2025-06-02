<?php

namespace app\modules\quests\services;

use app\modules\quests\services\QuestService;
use app\modules\quests\api\telegram\TelegramBot;

class QuizService
{
    private $bot;
    private $questService;

    public function __construct(TelegramBot $bot)
    {
        // Перенести token в настройки
        // $token = "8141427100:AAHPCcqQvOd5SByBZIe1UtaKc3bXk-A9Bu4";

        $this->bot = $bot;
        // $this->bot = \Yii::$container->get(TelegramBot::class, ['token' => $token]);
        $this->questService = \Yii::$container->get(QuestService::class);
    }

    /**
     * Ответ на callback запрос (для inline кнопок)
     * @param string $callbackQueryId - ID callback запроса
     * @param string $text - текст ответа
     * @param bool $showAlert - показывать alert вместо toast уведомления
     * @return array
     */
    public function answerCallbackQuery($callbackQueryId, $text = '', $showAlert = false) {
        $params = [
            'callback_query_id' => $callbackQueryId,
            'text' => $text,
            'show_alert' => $showAlert
        ];
        
        return $this->bot->request('answerCallbackQuery', $params);
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

        $chatId = 215488627;
        $this->bot->sendMessage($chatId, print_r($data, true));
        
        try {
            // Ответим на callback (чтобы убрать "часики" у кнопки)
            $this->answerCallbackQuery($callbackQueryId);
            
            // Разбираем данные кнопки (можно использовать JSON или разделители)
            $buttonData = $this->parseButtonData($data);

            $chatId = 215488627;
            $this->bot->sendMessage($chatId, "Action: ". $buttonData['action']);
            
            // Обрабатываем действие в зависимости от данных кнопки
            switch ($buttonData['action']) {
                case 'quests':
                    $this->sendQuests($chatId);
                    break;

                case 'show_quest':
                    $this->sendQuestInfo($chatId, (int) $buttonData['value']);
                    break;

                case 'start_quest':
                    $this->startQuest($chatId, (int) $buttonData['value']);
                    break;

                // case 'quest_tasks':
                    // $this->getQuestTasks($chatId, (int) $buttonData['value']);
                    // $this->sendMessage($chatId, "Вы выбрали квест №: {$buttonData['value']}");
                    // break;
                    
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
            case '/quests':
                $this->sendQuests($chatId);
                break;
                
            case '/menu':
                $this->sendMenu($chatId);
                break;
                
            default:
                $this->bot->sendMessage($chatId, "Неизвестная команда: $command");
        }
    }

    /**
     * Отправка стартового сообщения
     * @param int $chatId - ID чата
     */
    protected function sendStartMessage($chatId) 
    {
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

    protected function sendQuests($chatId) 
    {
        $quests = $this->questService->getVisible();
        if (count($quests) > 0) {
            $keyboard = $this->questService->generateQuestKeyboard($quests);

            $this->bot->sendMessage($chatId, "Добро пожаловать! Список доступных квестов:", [
                'reply_markup' => json_encode($keyboard)
            ]);
        } else {
            $this->bot->sendMessage($chatId, 'В данный момент нет активных квестов 😟');
        }
    }

    // Отправка информации о выбранном квесте и кнопку запуска квеста
    protected function sendQuestInfo($chatId, int $questId)
    {
        $this->bot->sendMessage($chatId, "Send quest info");
        $quest = $this->questService->find((int) $questId);
        if ($quest == null) {
            return $this->bot->sendMessage($chatId, 'К сожалению данная прогулка не найдена или неактивна 😟');
        }

        $message = $quest->desc;
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Начать прогулку', 'callback_data' => 'start_quest:'.$quest->id],
                ],
            ]
        ];

        if ($quest->image) {
            return $this->bot->sendPhoto($chatId, $quest->imageFullPath, $message, [
                'reply_markup' => json_encode($keyboard)
            ]);
        }

        return $this->bot->sendMessage($chatId, $message, [
            'reply_markup' => json_encode($keyboard)
        ]);
    }

    protected function startQuest($chatId, int $questId)
    {
        $quest = $this->questService->find((int) $questId);
        if ($quest == null) {
            return $this->bot->sendMessage($chatId, 'К сожалению данная прогулка не найдена или неактивна 😟');
        }

        return $this->bot->sendMessage($chatId, "Прогулка начинается!");
    }

    /**
     * Получение вопросов по квесту
     * @param mixed $chatId
     * @param mixed $questId
     * @return void
     */
    // protected function getQuestTasks($chatId, $questId)
    // {
    //     $quest = $this->questService->find((int)$questId);
    //     if ($quest == null) {
    //         $this->sendMessage($chatId, 'К сожалению квест не найден 😟');
    //     }

    //     $tasks = $quest->visibleTasks;
    //     if (count($tasks) == 0) {
    //         $this->sendMessage($chatId, 'Данный квест не содержит вопросов 😟');
    //     }

    //     $keyboard = $this->questService->generateTasksKeyboard($tasks);
    //     $options['reply_markup'] = json_encode($keyboard);
        
    //     $caption = $quest->desc;

    //     if ($quest->imagePath) {
    //         $this->sendPhoto($chatId, $quest->imageFullPath, $caption, $options);
    //     } else {
    //         if ($quest->desc) {
    //             $this->sendMessage($chatId, $caption, $options);
    //         }
    //     }
    // }
    
    /**
     * Отправка меню
     * @param int $chatId - ID чата
     */
    public function sendMenu($chatId) {
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
    protected function handleMessage($chatId, $text) {
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
}