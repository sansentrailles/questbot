<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\frontend;

use app\modules\quests\services\QuizService;
use Yii;
use app\modules\quests\api\telegram\TelegramBot;
use app\modules\quests\controllers\common\Controller;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    // public function actionIndex(): void
    // {
    //     echo 123;
    //     exit;
    // }

    public function actionHandler()
    {
        // $update = $bot->getWebhookUpdate();
        // $bot->handleUpdate($update);

        // $chatId = 215488627;
        $token = "8141427100:AAHPCcqQvOd5SByBZIe1UtaKc3bXk-A9Bu4";
        $bot = new TelegramBot($token);
        $quizService = new QuizService($bot);

        $update = $bot->getWebhookUpdate();
        $quizService->handleUpdate($update);

        // Пример обработки входящих сообщений (для webhook)
        // $update = $bot->getWebhookUpdate();
        // $bot->handleUpdate($update);

        // $quests = $this->questService->getAll();
        // if (count($quests) > 0) {
        //     $keyboard = $this->questService->generateQuestKeyboard($quests);

        //     $bot->sendPhoto(215488627, $quests[0]->imageFullPath, 'Квест!', [
        //         // 'caption' => 'Квесты:',
        //         // 'has_spoiler' => true,
        //         'reply_markup' => json_encode($keyboard)
        //     ]);
        //     // $bot->sendMessage($chatId, "Добро пожаловать! Выберите квест:", [
        //     //     'reply_markup' => json_encode($keyboard)
        //     // ]);
        // }

        // try {
        //     if (isset($update['message'])) {
        //         $chatId = $update['message']['chat']['id'];
        //         $text = $update['message']['text'];
        //         if ($text == '/start') {
        //             $quests = $this->questService->getAll();
        //             if (count($quests) > 0) {
        //                 $keyboard = $this->questService->generateQuestKeyboard($quests);

        //                 $bot->sendMessage($chatId, "Добро пожаловать! Выберите квест:", [
        //                     'reply_markup' => json_encode($keyboard)
        //                 ]);
        //             } else {
        //                 $bot->sendMessage($chatId, 'В данный момент нет активных квестов 😟');
        //             }
                    
        //         } elseif ($text == '/getid') {
        //             $bot->sendMessage($chatId, 'ChatID: ' . $chatId);
        //         } else {
        //             $bot->sendMessage($chatId, 'Вы написали: ' . $text);
        //         }
        //     }
        // } catch (\Exception $e) {
        //     $bot->sendMessage(215488627, 'Error');
        // }
        
        
        Yii::$app->response->setStatusCode(200);
        return 'ok';
    }
}
