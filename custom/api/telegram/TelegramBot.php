<?php

namespace app\custom\api\telegram;

use app\modules\quests\services\QuestService;

class TelegramBot
{
    private $token;
    private $apiUrl;

    private $questService;
    
    /**
     * Конструктор класса
     * @param string $token - токен вашего бота, полученный от @BotFather
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
        $this->questService = \Yii::$container->get(QuestService::class);
    }
    
    /**
     * Отправка запроса к API Telegram
     * @param string $method - метод API (например, 'getMe', 'sendMessage')
     * @param array $params - параметры запроса
     * @return array - ответ от API
     */
    private function request($method, $params = []) 
    {
        $url = $this->apiUrl . $method;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if (!$result['ok']) {
            throw new \Exception('API error: ' . $result['description']);
        }
        
        return $result['result'];
    }
    
    /**
     * Получение информации о боте
     * @return array - информация о боте
     */
    public function getMe() {
        return $this->request('getMe');
    }
    
    /**
     * Отправка сообщения
     * @param int $chatId - ID чата
     * @param string $text - текст сообщения
     * @param array $options - дополнительные параметры (parse_mode, reply_markup и т.д.)
     * @return array - информация об отправленном сообщении
     */
    public function sendMessage($chatId, $text, $options = []) {
        $params = array_merge([
            'chat_id' => $chatId,
            'text' => $text
        ], $options);
        
        return $this->request('sendMessage', $params);
    }
    
    /**
     * Отправка фото
     * @param int $chatId - ID чата
     * @param string $photo - путь к файлу или URL фото
     * @param string $caption - подпись к фото
     * @param array $options - дополнительные параметры
     * @return array - информация об отправленном фото
     */
    public function sendPhoto($chatId, $photo, $caption = '', $options = []) {
        $params = array_merge([
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption
        ], $options);
        
        // Если фото - локальный файл
        if (file_exists($photo)) {
            $params['photo'] = new \CURLFile(realpath($photo));
        }
        
        return $this->request('sendPhoto', $params);
    }
    
    /**
     * Получение обновлений (входящих сообщений)
     * @param int $offset - ID последнего полученного обновления
     * @param int $limit - максимальное количество обновлений для получения
     * @param int $timeout - время ожидания в секундах
     * @return array - массив обновлений
     */
    public function getUpdates($offset = 0, $limit = 100, $timeout = 0) {
        $params = [
            'offset' => $offset,
            'limit' => $limit,
            'timeout' => $timeout
        ];
        
        return $this->request('getUpdates', $params);
    }
    
    /**
     * Установка webhook
     * @param string $url - URL для получения обновлений
     * @param array $options - дополнительные параметры (certificate, max_connections и т.д.)
     * @return bool - true в случае успеха
     */
    public function setWebhook($url, $options = []) {
        $params = array_merge([
            'url' => $url
        ], $options);
        
        return $this->request('setWebhook', $params);
    }
    
    /**
     * Удаление webhook
     * @return bool - true в случае успеха
     */
    public function deleteWebhook() {
        return $this->request('deleteWebhook');
    }
    
    /**
     * Получение информации о webhook
     * @return array - информация о текущем webhook
     */
    public function getWebhookInfo() {
        return $this->request('getWebhookInfo');
    }
    
    /**
     * Обработка входящего обновления (для webhook)
     * @return array - распарсенное обновление
     */
    public function getWebhookUpdate() {
        $input = file_get_contents('php://input');
        return json_decode($input, true);
    }
    
    /**
     * Ответ на callback запрос (для inline кнопок)
     * @param string $callbackQueryId - ID callback запроса
     * @param string $text - текст ответа
     * @param bool $showAlert - показывать alert вместо toast уведомления
     * @return bool - true в случае успеха
     */
    public function answerCallbackQuery($callbackQueryId, $text = '', $showAlert = false) {
        $params = [
            'callback_query_id' => $callbackQueryId,
            'text' => $text,
            'show_alert' => $showAlert
        ];
        
        return $this->request('answerCallbackQuery', $params);
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
            $this->answerCallbackQuery($callbackQueryId);
            
            // Разбираем данные кнопки (можно использовать JSON или разделители)
            $buttonData = $this->parseButtonData($data);
            
            // Обрабатываем действие в зависимости от данных кнопки
            switch ($buttonData['action']) {
                case 'show_text':
                    $this->sendMessage($chatId, "Вы нажали кнопку: {$buttonData['value']}");
                    break;

                case 'quest_questions':
                    $this->getQuestQuestions($chatId, (int) $buttonData['value']);
                    // $this->sendMessage($chatId, "Вы выбрали квест №: {$buttonData['value']}");
                    break;
                    
                case 'delete_message':
                    $this->deleteMessage($chatId, $messageId);
                    break;
                    
                case 'edit_message':
                    $this->editMessageText($chatId, $messageId, "Сообщение изменено!");
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
     * Удаление сообщения
     * @param int $chatId - ID чата
     * @param int $messageId - ID сообщения
     * @return bool - результат операции
     */
    public function deleteMessage($chatId, $messageId) {
        $params = [
            'chat_id' => $chatId,
            'message_id' => $messageId
        ];
        
        return $this->request('deleteMessage', $params);
    }
    
    /**
     * Редактирование текста сообщения
     * @param int $chatId - ID чата
     * @param int $messageId - ID сообщения
     * @param string $newText - новый текст
     * @param array $options - дополнительные параметры
     * @return array - результат операции
     */
    public function editMessageText($chatId, $messageId, $newText, $options = []) {
        $params = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $newText
        ], $options);
        
        return $this->request('editMessageText', $params);
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
                $this->sendMessage($chatId, "Неизвестная команда: $command");
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
        
        $this->sendMessage($chatId, "Добро пожаловать! Выберите действие:", [
            'reply_markup' => json_encode($keyboard)
        ]);
    }

    protected function sendQuests($chatId) 
    {
        $quests = $this->questService->getAll();
        if (count($quests) > 0) {
            $keyboard = $this->questService->generateQuestKeyboard($quests);

            $this->sendMessage($chatId, "Добро пожаловать! Список доступных квестов:", [
                'reply_markup' => json_encode($keyboard)
            ]);
        } else {
            $this->sendMessage($chatId, 'В данный момент нет активных квестов 😟');
        }
    }

    /**
     * Получение вопросов по квесту
     * @param mixed $chatId
     * @param mixed $questId
     * @return void
     */
    protected function getQuestQuestions($chatId, $questId)
    {
        $quest = $this->questService->find((int)$questId);
        if ($quest == null) {
            $this->sendMessage($chatId, 'К сожалению квест не найден 😟');
        }

        $tasks = $quest->visibleTasks;
        if (count($tasks) == 0) {
            $this->sendMessage($chatId, 'Данный квест не содержит вопросов 😟');
        }

        $keyboard = $this->questService->generateTasksKeyboard($tasks);
        $options['reply_markup'] = json_encode($keyboard);

        if ($quest->imagePath) {
            if ($quest->desc) {
                $options['caption'] = $quest->desc;
            }
            $this->sendPhoto($chatId, $quest->imageFullPath, $options);
        } else {
            if ($quest->desc) {
                $this->sendMessage($chatId, $quest->desc, $options);
            }
        }
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
        
        $this->sendMessage($chatId, "Главное меню:", [
            'reply_markup' => json_encode($keyboard)
        ]);
    }
    
    /**
     * Обработка обычных сообщений (можно переопределить в дочернем классе)
     * @param int $chatId - ID чата
     * @param string $text - текст сообщения
     */
    protected function handleMessage($chatId, $text) {
        $this->sendMessage($chatId, "Вы написали: $text");
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
                    $this->sendMessage($chatId, "Это информационное сообщение.");
                    break;
                    
                case 'settings':
                    $this->sendMessage($chatId, "Настройки бота...");
                    break;
                    
                case 'help':
                    $this->sendMessage($chatId, "Помощь по боту...");
                    break;
                    
                case 'close':
                    $this->deleteMessage($chatId, $messageId);
                    break;
            }
        }
    }
}
