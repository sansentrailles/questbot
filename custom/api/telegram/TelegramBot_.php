<?php

namespace app\custom\api\telegram;

use GuzzleHttp\Client;

class TelegramBot
{
    private $token;
    private $apiUrl;
    private $client;

    public function __construct($token)
    {
        $this->token = $token;
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
        ]);
    }

    /**
     * Отправляет текстовое сообщение.
     *
     * @param int $chatId Идентификатор чата
     * @param string $text Текст сообщения
     * @param array $options Дополнительные параметры (например, parse_mode, reply_markup)
     * @return mixed
     */
    public function sendMessage($chatId, $text, $options = [])
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        $params = array_merge($params, $options);

        return $this->request('sendMessage', $params);
    }

    /**
     * Получает обновления от Telegram.
     *
     * @param int $offset Идентификатор первого обновления, которое нужно получить
     * @param int $limit Максимальное количество обновлений за один запрос
     * @param int $timeout Время ожидания ответа в секундах
     * @return mixed
     */
    public function getUpdates($offset = 0, $limit = 100, $timeout = 0)
    {
        $params = [
            'offset' => $offset,
            'limit' => $limit,
            'timeout' => $timeout,
        ];

        return $this->request('getUpdates', $params);
    }

    /**
     * Отправляет изображение.
     *
     * @param int $chatId Идентификатор чата
     * @param string $photo Путь к изображению или URL
     * @param array $options Дополнительные параметры (например, caption, parse_mode)
     * @return mixed
     */
    public function sendPhoto($chatId, $photo, $options = [])
    {
        $params = [
            'chat_id' => $chatId,
            'photo' => $photo,
        ];

        $params = array_merge($params, $options);

        return $this->request('sendPhoto', $params);
    }

    /**
     * Отправляет документ.
     *
     * @param int $chatId Идентификатор чата
     * @param string $document Путь к документу или URL
     * @param array $options Дополнительные параметры (например, caption, parse_mode)
     * @return mixed
     */
    public function sendDocument($chatId, $document, $options = [])
    {
        $params = [
            'chat_id' => $chatId,
            'document' => $document,
        ];

        $params = array_merge($params, $options);

        return $this->request('sendDocument', $params);
    }

    /**
     * Отправляет аудиофайл.
     *
     * @param int $chatId Идентификатор чата
     * @param string $audio Путь к аудиофайлу или URL
     * @param array $options Дополнительные параметры (например, caption, parse_mode)
     * @return mixed
     */
    public function sendAudio($chatId, $audio, $options = [])
    {
        $params = [
            'chat_id' => $chatId,
            'audio' => $audio,
        ];

        $params = array_merge($params, $options);

        return $this->request('sendAudio', $params);
    }

    /**
     * Отправляет видеофайл.
     *
     * @param int $chatId Идентификатор чата
     * @param string $video Путь к видеофайлу или URL
     * @param array $options Дополнительные параметры (например, caption, parse_mode)
     * @return mixed
     */
    public function sendVideo($chatId, $video, $options = [])
    {
        $params = [
            'chat_id' => $chatId,
            'video' => $video,
        ];

        $params = array_merge($params, $options);

        return $this->request('sendVideo', $params);
    }

    /**
     * Выполняет запрос к API Telegram.
     *
     * @param string $method Метод API
     * @param array $params Параметры запроса
     * @return mixed
     */
    private function request($method, $params = [])
    {
        try {
            $response = $this->client->request('POST', $method, [
                'form_params' => $params,
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            if ($data['ok']) {
                return $data['result'];
            } else {
                throw new \Exception("Ошибка API: " . $data['description']);
            }
        } catch (\Exception $e) {
            echo "Произошла ошибка: " . $e->getMessage();
            return null;
        }
    }
}