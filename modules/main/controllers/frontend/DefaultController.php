<?php

declare(strict_types=1);

namespace app\modules\main\controllers\frontend;

use app\modules\main\controllers\common\Controller;
use OpenApi\Attributes as OA;
use Yii;

class DefaultController extends Controller
{
    public function actionError(): void
    {
        echo 'error';
        $exception  =   Yii::$app->getErrorHandler()->exception;
        print_r($exception);
        exit;
    }
}
