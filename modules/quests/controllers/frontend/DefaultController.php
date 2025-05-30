<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\frontend;

use Yii;
use app\custom\api\telegram\TelegramBot;
use app\modules\quests\controllers\common\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): void
    {
        echo 123;
        exit;
    }

    public function actionHandler()
    {
        $token = "8141427100:AAHPCcqQvOd5SByBZIe1UtaKc3bXk-A9Bu4";
        
        $bot = new TelegramBot($token);

        // Пример обработки входящих сообщений (для webhook)
        $update = $bot->getWebhookUpdate();
        // $bot->handleUpdate($update);

        $bot->sendMessage(215488627, 'Enter');

        try {
            if (isset($update['message'])) {
                $chatId = $update['message']['chat']['id'];
                $text = $update['message']['text'];
                
                if ($text == '/start') {
                    $bot->sendMessage($chatId, 'Добро пожаловать!');
                } elseif ($text == '/getid') {
                    $bot->sendMessage($chatId, 'ChatID: ' . $chatId);
                } else {
                    $bot->sendMessage($chatId, 'Вы написали: ' . $text);
                }
            }
        } catch (\Exception $e) {
            $bot->sendMessage(215488627, 'Error');
        }
        
        
        Yii::$app->response->setStatusCode(200);
        return 'ok';
    }
}
