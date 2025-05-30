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
        $bot->handleUpdate($update);

        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];
            
            if ($text == '/start') {
                $bot->sendMessage($chatId, 'Добро пожаловать!');
            } else {
                $bot->sendMessage($chatId, 'Вы написали: ' . $text);
            }
        }
        exit;
    }
}
