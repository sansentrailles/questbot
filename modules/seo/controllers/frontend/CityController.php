<?php

declare(strict_types=1);

namespace app\modules\seo\controllers\frontend;

use app\modules\seo\controllers\common\RestController;
use Yii;
use yii\web\Response;


class CityController extends RestController
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionList()
    {
        return $this->cityService->getAll();
    }

    public function actionGetDefault()
    {
        return $this->cityService->getDefault();
    }

}
