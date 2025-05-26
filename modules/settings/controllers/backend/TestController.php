<?php

declare(strict_types=1);

namespace app\modules\settings\controllers\backend;

use app\modules\settings\controllers\common\Controller;
use Yii;
use yii\filters\VerbFilter;

class TestController extends Controller
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

    public function actionIndex()
    {
        $setting = Yii::$app->setting;

        print_r($setting->get('api.file'));
        // $setting->get('scripts.url');
        // $setting->get('feedback');

        exit;
        return $this->render('index', []);
    }
}
