<?php

declare(strict_types=1);

namespace app\modules\user\controllers\backend;

use app\modules\user\controllers\common\Controller;
use app\modules\user\forms\backend\search\UserSearch as SearchModel;
use app\modules\user\forms\backend\UserForm as Form;
use app\modules\user\Module;
use Yii;
use yii\filters\VerbFilter;

/**
 * Default controller for the `user` module.
 */
class DefaultController extends Controller
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
        $model->scenario = Form::SCENARIO_CREATE;

        if ($model->load($post) && $model->validate()) {
            $user = $this->userService->save($model);

            // if($user) {
            //     print_r($model->roles); exit;
            //     $this->rbacService->assignRoles($user->id, $model->roles);
            // }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $this->rbacService->getRoles(),
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $user = $this->userService->findOrFail((int)$id);
        $model = new Form($user);
        $model->scenario = Form::SCENARIO_UPDATE;

        if ($model->load($post) && $model->validate()) {
            $user = $this->userService->save($model);
            if ($user) {
                $this->rbacService->assignRoles($user->id, [$model->role]);
            }

            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $this->rbacService->getRoles(),
        ]);
    }

    public function actionToggleVisible($id)
    {
        $this->guardRequestPostAjax();
        $state = $this->userService->toggleVisible($id);

        return [
            'status' => 'ok',
            'value' => $state,
            'message' => 'The requested card has been switched successfully',
        ];
    }

    public function actionDelete($id)
    {
        $model = $this->userService->findOrFail($id);
        $this->userService->delete($id);

        return $this->redirect(['index']);
    }
}
