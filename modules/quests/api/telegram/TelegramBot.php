<?php

namespace app\modules\quests\api\telegram;

class TelegramBot
{
    private $token;
    private $apiUrl;
    
    /**
     * Конструктор класса
     * @param string $token - токен вашего бота, полученный от @BotFather
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
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
     * Отправка голосования (опроса)
     * @param int $chatId - ID чата
     * @param string $question - вопрос опроса
     * @param array $variants - массив вариантов ответов (минимум 2, максимум 10)
     * @param array $options - дополнительные параметры (is_anonymous, allows_multiple_answers и т.д.)
     * @return array - информация об отправленном голосовании
     */
    public function sendPoll($chatId, $question, $variants, $options = []) {
        $params = array_merge([
            'chat_id' => $chatId,
            'question' => $question,
            'options' => json_encode(array_values($variants)), // Ограничиваем до 10 вариантов
        ], $options);

        return $this->request('sendPoll', $params);
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
     * @return array
     */
    public function setWebhook($url, $options = []) {
        $params = array_merge([
            'url' => $url
        ], $options);
        
        return $this->request('setWebhook', $params);
    }
    
    /**
     * Удаление webhook
     * @return array
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
     * @return array
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
     * Удаление сообщения
     * @param int $chatId - ID чата
     * @param int $messageId - ID сообщения
     * @return array - результат операции
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
}
