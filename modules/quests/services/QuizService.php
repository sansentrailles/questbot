<?php

namespace app\modules\quests\services;

use app\modules\quests\api\telegram\TelegramBot;

class QuizService
{
    private $bot;
    private $questService;

    public function __construct(TelegramBot $bot)
    {
        $this->bot = $bot;
        $this->questService = \Yii::$container->get(QuestService::class);
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
                case 'show_text':
                    $this->bot->sendMessage($chatId, "Вы нажали кнопку: {$buttonData['value']}");
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

    private function showQuests($chatId)
    {
        $quests = $this->questService->getVisible();
        if (count($quests) > 0) {
            $keyboard = $this->questService->generateQuestKeyboard($quests);

            $this->bot->sendMessage($chatId, "Вас приветствует бот городских прогулок-викторин! Список доступных прогулок:", [
                'reply_markup' => json_encode($keyboard)
            ]);
        } else {
            $this->bot->sendMessage($chatId, 'В данный момент нет активных прогулок 😟');
        }
    }
}