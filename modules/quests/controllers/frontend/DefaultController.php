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
        // $message = "Текст с HTML\nНовая строка\n<i>Курсив</i>\n<span class='tg-spoiler'>text</span>";
        $chatId = 215488627;
        $token = "8141427100:AAHPCcqQvOd5SByBZIe1UtaKc3bXk-A9Bu4";

        $taskService = Yii::$container->get(\app\modules\quests\services\TaskService::class);
        $task = $taskService->find(2);

        $message = $task->question;
        
        $bot = new TelegramBot($token);

        // Формирование вариантов ответов, если вопрос с выбором варианта
        $keyboard = [];
        $hints = $task->visibleHints;
        $hintsCount = count($hints);
        if ($hintsCount > 0) {
            error_log('add hints button');
            $keyboard[] = [
                [
                    'text' => 'Подсказки (0/3)',
                    'callback_data' => 'show_hint:' . $task->quest_id,
                ]
            ];
        }

        if ($task->type == \app\modules\quests\models\Task::TYPE_CHOICE) {
            $answers = $task->answers;

            foreach ($answers as $answer) {
                $keyboard[] = [
                    [
                        'text' => $answer->title,
                        'callback_data' => 'task_answer:' . $answer->id.'@'.$task->quest_id
                    ]
                ];
            }
        } else {
            $message .= "\n\nВведите ответ на вопрос: ";
        }

        $options = [];
        if (count ($keyboard) > 0) {
            $replyMarkup = [
                'inline_keyboard' => $keyboard
            ];

            $options['reply_markup'] = json_encode($replyMarkup);
        }

        if ($task->image) {
            return $this->bot->sendPhoto($chatId, $task->imageFullPath, $message, $options);
        }

        $bot->sendMessage($chatId, $message, $options);

//         $message = "
// *Жирный текст* и _курсивный текст_  
// ~~Зачёркнуто~~ и `моноширинный код`  
// ~Зачёркнуто~ и `моноширинный код`  
// __underline__

// [Ссылка на Google](https://google.com)  
// [Упомянуть пользователя](tg://user?id=215488627)  

// ||Спойлер скрыт||  
// Экранирование: \\*не жирный\\*
// ";
// $message = "
// *bold \*text*
// _italic \*text_
// __underline__
// ~strikethrough~
// ||spoiler||
// *bold _italic bold ~italic bold strikethrough ||italic bold strikethrough spoiler||~ __underline italic bold___ bold*
// [inline URL](http://www.example.com/)
// [inline mention of a user](tg://user?id=123456789)
// ![👍](tg://emoji?id=5368324170671202286)
// `inline fixed-width code`
// ";


        // $bot = new TelegramBot($token);
        // $bot->sendMessage($chatId, $message, [
        //     'parse_mode' => 'markdownv2',
        // ]);
        exit;
    }
}
