<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\frontend;

use Yii;
use app\modules\quests\services\QuizService;
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
        $chatId = 215488627;
        $token = "8141427100:AAHPCcqQvOd5SByBZIe1UtaKc3bXk-A9Bu4";

        $bot = new TelegramBot($token);
        $quizService = new QuizService($bot);
        $update = $bot->getWebhookUpdate();
        $quizService->handleUpdate($update);

        // $question = "Сколько месяцев в году?";
        // $variants = [
        //     "5",
        //     "7",
        //     "12",
        //     "17",
        // ];
        // $options = [
        //     'type' => 'quiz',
        //     'correct_option_id' => 2,
        //     'explanation' => "В году 12 месяцев"
        // ];
        // $bot->sendPoll($chatId, $question, $variants, $options);

        // $bot = new TelegramApi($token);
        // $update = $bot->getWebhookUpdate();
        // $bot->handleUpdate($update);

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

    public function actionHelp()
    {
        $callback_data = '1[#]матрица';
        list($taskId, $answer) = explode('[#]', $callback_data);

        print_r([
            'taskId' => $taskId,
            'answer' => $answer,
        ]);
        exit;

        // $message =  "Ваш ответ: \nОтвет\n\nНажмите \"Принять ✅\" для подтверждения или введите новый ответ";
        // $bot->sendMessage($chatId, $message, [
        //     'reply_markup' => json_encode($keyboard),
        //     'parse_mode' => 'HTML'
        // ]);

        // echo \yii\helpers\Html::encode('apply_answer:'.json_encode($payload));

        // $helpButton = ['text' => 'Справка / Рекомендации ℹ️', 'callback_data' => 'quest_help:1'];
        // $startButton = ['text' => 'Начать прогулку ▶️', 'callback_data' => 'start_quest:1'];

        // $help = 'Справка по квесту:';
        // if ($help) {
        //     $inlineKeyboards[] = [$helpButton];
        // }

        // $inlineKeyboards[] = [$startButton];

        // $keyboard = [
        //     'inliene_keyboard' => $inlineKeyboards,
        // ];

        // print_r($keyboard);
        // echo "----------------------------<br>";
        // $keyboard = [
        //     'inline_keyboard' => [
        //         [
        //             ['text' => 'Начать прогулку ▶️', 'callback_data' => 'start_quest:1'],
        //         ],
        //     ]
        // ];
        // print_r($keyboard);
        exit;
    }
}
