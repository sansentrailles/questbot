<?php

declare(strict_types=1);

namespace app\modules\main\controllers\frontend;

use app\modules\main\controllers\common\Controller;
use Yii;
use yii\web\Response;


class MainController extends Controller
{
    public function actionIndex()
    {
        $this->layout = '@app/views/layouts/frontend/dummy';
        return $this->render('index');
    }
}
