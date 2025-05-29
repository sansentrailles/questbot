<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\backend;

use Yii;
use Exception;
use yii\filters\VerbFilter;
use app\modules\quests\Module;
use app\modules\quests\controllers\common\Controller;
use app\modules\quests\forms\backend\AnswerForm as Form;
use app\modules\quests\forms\backend\search\AnswerSearch as SearchModel;

class AnswersController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'sort' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($taskId)
    {
        $task = $this->taskService->findOrFail((int)$taskId);

        $searchModel = new SearchModel();

        $dataProvider = $searchModel
            ->forTask($taskId)
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'task' => $task,
        ]);
    }

    public function actionCreate($taskId)
    {
        $task = $this->taskService->findOrFail((int)$taskId);

        $post = Yii::$app->request->post();
        $model = new Form();
        $model->setTask($taskId);

        if ($model->load($post) && $model->validate()) {
            $this->answerService->save($model);

            return $this->redirect(['index', 'taskId' => $taskId]);
        }

        return $this->render('create', [
            'model' => $model,
            'task' => $task,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->answerService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->answerService->save($model);

            return $this->redirect(['index', 'taskId' => $model->quest_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'task' => $entity->task,
        ]);
    }

    public function actionDelete($id)
    {
        $entity = $this->answerService->findOrFail((int)$id);
        $taskId = $entity->task_id;
        $this->answerService->delete($id);

        return $this->redirect(['index', 'taskId' => $taskId]);
    }

    public function actionSort()
    {
        $request = Yii::$app->request;
        $ords = $request->post('orders');

        if (empty($ords)) {
            return $this->redirect($request->referrer);
        }

        $this->answerService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }

    public function actionToggleRight($id)
    {
        $this->guardRequestPostAjax();
        $this->answerService->findOrFail((int)$id);
        $state = $this->answerService->toggleRight((int)$id);

        if ($state === null) {
            return [
                'status' => 'error',
                'message' => 'The requested attribute has already been switched',
            ];
        }
        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested attribute has been switched successfully',
        ];
    }
}
