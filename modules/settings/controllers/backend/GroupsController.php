<?php

declare(strict_types=1);

namespace app\modules\settings\controllers\backend;

use app\modules\settings\controllers\common\Controller;
use app\modules\settings\forms\backend\search\SettingGroupSearch;
use app\modules\settings\forms\backend\SettingGroupForm;
use app\modules\settings\Module;
use Yii;
use yii\filters\VerbFilter;

/**
 * Groups controller for the `setting` module.
 */
class GroupsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'sort' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($group = null)
    {
        $searchModel = new SettingGroupSearch();
        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new SettingGroupForm();

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $settingGroup = $this->settingsGroupService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $settingGroup = $this->settingsGroupService->find((int)$id);
        $model = new SettingGroupForm($settingGroup);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $group = $this->settingsGroupService->save($model);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $setting = $this->settingsGroupService->find((int)$id);
        $this->settingsGroupService->delete($id);

        return $this->redirect(['index']);
    }
}
