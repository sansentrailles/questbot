<?php

namespace app\modules\seo\controllers\backend;

use Yii;
use yii\filters\VerbFilter;
use app\modules\seo\controllers\common\Controller;
use app\modules\seo\forms\backend\search\CitySearch as SearchModel;
use app\modules\seo\forms\backend\CityForm as Form;
use app\modules\seo\Module;

class CitiesController extends Controller
{
    /**
     * @inheritdoc
     */
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
            $this->cityService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $entity = $this->cityService->find($id);
        $model = new Form($entity);

        if ($model->load($post) && $model->validate()) {
            $this->cityService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->cityService->findOrFail($id);
        $this->cityService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->cityService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested photo has been switched successfully',
        ];
    }

    public function actionSort()
    {
        $request = Yii::$app->request;
        $ords = $request->post('orders');

        if (empty($ords)) {
            return $this->redirect($request->referrer);
        }

        $this->cityService->changeOrder($ords);
        Yii::$app->getSession()->setFlash('success', Module::t('common', 'ORD_SAVED_SUCCESS'));
        return $this->redirect($request->referrer);
    }

    public function actionToggleDefault($id)
    {
        $this->guardRequestPostAjax();
        $this->cityService->findOrFail((int)$id);
        $state = $this->cityService->toggleDefault((int)$id);

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
