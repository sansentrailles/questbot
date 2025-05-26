<?php

declare(strict_types=1);

namespace app\modules\user\controllers\backend;

use app\modules\user\controllers\common\Controller;
use app\modules\user\forms\backend\RoleForm as Form;
use app\modules\user\forms\backend\search\RoleSearch as SearchModel;
use app\modules\user\Module;
use Yii;
use yii\filters\VerbFilter;

/**
 * Roles controller for the `user` module.
 */
class RolesController extends Controller
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
            $this->rbacService->createRole($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'permissions' => $this->rbacService->getPermissions(),
        ]);
    }

    public function actionUpdate($name)
    {
        $post = Yii::$app->request->post();
        $role = $this->rbacService->getRole($name);
        $model = new Form($role);

        if ($model->load($post) && $model->validate()) {
            $this->rbacService->updateRole($model);

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'permissions' => $this->rbacService->getPermissions(),
        ]);
    }

    public function actionDelete($id)
    {
        $role = $this->rbacService->getRole($id);
        $this->rbacService->delete($role);

        return $this->redirect(['index']);
    }
}
