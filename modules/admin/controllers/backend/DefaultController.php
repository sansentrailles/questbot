<?php

declare(strict_types=1);

namespace app\modules\admin\controllers\backend;

use yii\web\Controller;

/**
 * Default controller for the `admin` module.
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module.
     * @return string
     */
    public function actionIndex()
    {
        // return $this->redirect(['/admin/page']);
        return $this->render('index');
    }

    public function actionHelp()
    {
        return $this->render('help');
    }

    public function actionFilemanager()
    {
        return $this->render('filemanager');
    }
}
