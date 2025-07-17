<?php

declare(strict_types=1);

namespace app\modules\main\controllers\frontend;

use app\modules\main\controllers\common\Controller;

class DefaultController extends Controller
{
    public function actionError()
    {
        $this->layout = '@app/views/layouts/frontend/error';
        $exception  = \Yii::$app->getErrorHandler()->exception;
        return $this->render('error', [
            'exception' => $exception,
        ]);
    }
}
