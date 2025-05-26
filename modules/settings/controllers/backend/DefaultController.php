<?php

declare(strict_types=1);

namespace app\modules\settings\controllers\backend;

use app\modules\settings\controllers\common\Controller;
use app\modules\settings\forms\backend\search\SettingSearch;
use app\modules\settings\forms\backend\SettingForm;
use app\modules\settings\models\Setting;
use app\modules\settings\Module;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `setting` module.
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
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'allow' => 'true',
            //             'roles' => ['admin'],
            //             'actions' => ['index', 'update', 'add-field', 'remove-field'],
            //         ],
            //         [
            //             'allow' => 'true',
            //             'roles' => ['dev'],
            //             'actions' => ['delete', 'create'],
            //         ],
            //     ],
            // ],
        ];
    }

    public function actionIndex($group = null)
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel
            ->forGroup($group)
            ->search(Yii::$app->request->queryParams, $withContent = true);

        $groups = $this->settingsGroupService->getAll();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterGroups' => ArrayHelper::map($groups, 'id', 'title'),
        ]);
    }

    public function actionCreate($typeId)
    {
        $model = new SettingForm();
        $model->setType($typeId);

        $post = Yii::$app->request->post();
        $isSaveAndEdit = Yii::$app->request->post('save_and_edit', 0);
        if ($model->load($post) && $model->validate()) {
            $setting = $this->settingsService->save($model);

            if ($isSaveAndEdit) {
                return $this->redirect(['update', 'id' => $setting->id]);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'groups' => $this->settingsGroupService->getAll(),
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $setting = $this->settingsService->find((int)$id);
        $valueModels = $this->settingsService->getValueForms($setting);
        $valueService = $this->settingsService->getValueService($setting->type_id);

        $model = new SettingForm($setting);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $this->settingsService->save($model);
            $this->settingsService->clearCache($setting);
            $data = Yii::$app->request->post($this->settingsService->getFormName($setting->type_id), []);

            foreach (array_keys($data) as $index) {
                if (!isset($valueModels[$index])) {
                    $form = $this->settingsService->createSettingValueForm($setting->type_id);
                    $form->setSettingId($id);
                    $valueModels[$index] = $form;
                }
            }

            if (Model::loadMultiple($valueModels, $post) && Model::validateMultiple($valueModels)) {
                $valueService->saveValues($valueModels);

                if ($setting && $setting->event_name) {
                    $this->settingsService->tirggerEvent($setting->event_name);
                }

                return $this->redirect(['index']);
            }
        }

        $valueName = $this->getValueType($setting->type_id);
        return $this->render('update', [
            'model' => $model,
            'setting' => $setting,
            'groups' => $this->settingsGroupService->getAll(),
            'isDev' => Yii::$app->user->can('dev'),
            'valueModels' => $valueModels,
            'itemTemplate' => 'values/' . $valueName,
        ]);
    }

    public function actionDelete($id)
    {
        $this->settingsService->find((int)$id);
        $this->settingsService->delete((int)$id);

        return $this->redirect(['index']);
    }

    public function actionAddField()
    {
        $this->guardRequestPostAjax();

        $index = Yii::$app->request->post('index', 0);
        $typeId = Yii::$app->request->post('type', 0);
        $settingId = Yii::$app->request->post('settingId', 0);
        if ($typeId === 0) {
            return [
                'status' => 'error',
                'message' => 'Unkown type',
            ];
        }

        if ($settingId === 0) {
            return [
                'status' => 'error',
                'message' => 'Unkown setting option',
            ];
        }

        $valueName = $this->getValueType($typeId);
        $template = 'inner/values/' . $valueName;
        $setting = $this->settingsService->find((int)$settingId);
        ++$index;

        return [
            'status' => 'ok',
            'html' => $this->renderAjax($template, [
                'isFirst' => false,
                'index' => $index,
                'setting' => $setting,
                'form' => \yii\widgets\ActiveForm::begin(),
                'valueModel' => $this->settingsService->createSettingValueForm($typeId),                // 'errors' => [],
            ]),
        ];
    }

    public function actionRemoveField()
    {
        $this->guardRequestPostAjax();

        $index = Yii::$app->request->post('index', 0);
        $settingId = Yii::$app->request->post('settingId', 0);

        if ($settingId === 0) {
            return [
                'status' => 'error',
                'message' => 'Unkown setting option',
            ];
        }

        $setting = $this->settingsService->find((int)$settingId);
        if ($setting === null) {
            return [
                'status' => 'error',
                'message' => 'Setting not found',
            ];
        }

        $this->settingsService->clearCache($setting);

        $valueService = $this->settingsService->getValueService((int)$setting->type_id);
        $value = $valueService->find((int)$index);

        if ($value) {
            $valueService->delete($value->id);
        }

        return [
            'status' => 'ok',
        ];
    }

    private function getValueType($typeId)
    {
        return Setting::getTypes()[$typeId]['name'];
    }
}
