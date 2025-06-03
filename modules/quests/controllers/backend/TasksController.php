<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\backend;

use Yii;
use Exception;
use yii\filters\VerbFilter;
use app\modules\quests\Module;
use app\modules\quests\controllers\common\Controller;
use app\modules\quests\forms\backend\TaskForm as Form;
use app\modules\quests\forms\backend\search\TaskSearch as SearchModel;

class TasksController extends Controller
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

    public function actionIndex($questId)
    {
        $quest = $this->questService->findOrFail((int)$questId);

        $searchModel = new SearchModel();

        $dataProvider = $searchModel
            ->forQuest($questId)
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'quest' => $quest,
        ]);
    }

    public function actionCreate($questId)
    {
        $quest = $this->questService->findOrFail((int)$questId);

        $post = Yii::$app->request->post();
        $model = new Form();
        $model->setQuest($questId);

        if ($model->load($post) && $model->validate()) {
            $this->taskService->save($model);

            return $this->redirect(['index', 'questId' => $questId]);
        }

        return $this->render('create', [
            'model' => $model,
            'quest' => $quest,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->taskService->find((int)$id);
        $model = new Form($entity);

        // $next = $this->taskService->getNext($entity);
        // if ($next) {
        //     echo $next->id.' '.$next->question.'<br>';
        //     echo \yii\helpers\Html::a("Next", ['/admin/quests/tasks/update', 'id' => $next->id]);
        // }

        if ($model->load($post) && $model->validate()) {
            $this->taskService->save($model);

            return $this->redirect(['index', 'questId' => $model->quest_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'quest' => $entity->quest,
        ]);
    }

    public function actionDelete($id)
    {
        $entity = $this->taskService->findOrFail((int)$id);
        $questId = $entity->quest_id;
        $this->taskService->delete($id);

        return $this->redirect(['index', 'questId' => $questId]);
    }

    public function actionDeleteImage($id)
    {
        $this->guardRequestPostAjax();

        try {
            $this->taskService->deleteImage($id);
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'cannot remove the requested file',
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'The requested file has been deleted successfully',
        ];
    }

    public function actionSort()
    {
        $request = Yii::$app->request;
        $ords = $request->post('orders');

        if (empty($ords)) {
            return $this->redirect($request->referrer);
        }

        $this->taskService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->taskService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested photo has been switched successfully',
        ];
    }
}
