<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\frontend;

use app\modules\quests\models\Quest;
use Yii;
use app\modules\quests\services\QuizService;
use app\modules\quests\api\telegram\TelegramBot;
use app\modules\quests\controllers\common\Controller;
use yii\web\HttpException;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionStat($uuid)
    {
        $stat = $this->statService->getByUuid($uuid);
        if ($stat == null) {
            throw new HttpException(404, 'Статистика не найдена');
        }

        $this->view->title = "Статистика прохождения прогулки";
        $this->layout = '@app/views/layouts/frontend/stat';
        
        // return $this->render('stat_static', [
        return $this->render('stat', [
            'stat' => $stat,
            'items' => $stat->items,
            'quest' => $stat->quest,
        ]);
    }

    public function actionView($id)
    {
        $quest = $this->questService->find((int) $id);
        if ($quest == null || $quest->is_visible == Quest::STATUS_INVISIBLE) {
            throw new HttpException(404, 'Квест не найден');
        }

        $this->layout = '@app/views/layouts/frontend/quest';
        $this->view->title = "Прогулка - " . $quest->title;

        $tasks = $quest->visibleTasks;

        return $this->render('view', [
            'quest' => $quest,
            'tasks' => $tasks,
            'tasksCount' => count($tasks),
        ]);
    }

    public function actionHandler()
    {
        // $token = "8141427100:AAHPCcqQvOd5SByBZIe1UtaKc3bXk-A9Bu4";
        $token = Yii::$app->setting->get('telegram.token');

        $bot = new TelegramBot($token);
        $quizService = new QuizService($bot);
        $update = $bot->getWebhookUpdate();
        $quizService->handleUpdate($update);

        Yii::$app->response->setStatusCode(200);
        return 'ok';
    }
}
