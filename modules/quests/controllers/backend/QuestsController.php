<?php

declare(strict_types=1);

namespace app\modules\quests\controllers\backend;

use app\modules\quests\controllers\common\Controller;
use app\modules\quests\forms\backend\QuestForm as Form;
use app\modules\quests\forms\backend\search\QuestSearch as SearchModel;
use Exception;
use Yii;
use yii\filters\VerbFilter;

class QuestsController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new SearchModel();

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $model = new Form();

        if ($model->load($post) && $model->validate()) {
            $this->questService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->questService->find((int)$id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->questService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->questService->findOrFail((int)$id);
        $this->questService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id)
    {
        $this->guardRequestPostAjax();

        try {
            $this->questService->deleteImage($id);
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
}
