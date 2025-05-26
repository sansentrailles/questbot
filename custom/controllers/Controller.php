<?php

declare(strict_types=1);

namespace app\custom\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Represents the base class for the project controllers.
 */
abstract class Controller extends \yii\web\Controller
{
    public function __construct(
        $id,
        $module,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    protected function guardRequestPostAjax(): void
    {
        $request = Yii::$app->request;

        if (!$request->isPost || !$request->isAjax) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    protected function setJsonResponse(): void
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
}
