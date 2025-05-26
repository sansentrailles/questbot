<?php

declare(strict_types=1);

namespace app\modules\user\controllers\backend;

use app\modules\user\controllers\common\Controller;
use app\modules\user\forms\backend\PermissionForm as Form;
use app\modules\user\forms\backend\search\PermissionSearch as SearchModel;
use app\modules\user\Module;
use Yii;
use yii\filters\VerbFilter;

/**
 * Permissions controller for the `user` module.
 */
class PermissionsController extends Controller
{
    /**
     * {@inheritdoc}
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
            $this->permissionService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($name)
    {
        $post = Yii::$app->request->post();
        $permission = $this->permissionService->findByName($name);
        $model = new Form($permission);

        if ($model->load($post) && $model->validate()) {
            $this->permissionService->save($model);

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $permission = $this->rbacService->getPermission($id);
        $this->rbacService->delete($permission);

        return $this->redirect(['index']);
    }
}
