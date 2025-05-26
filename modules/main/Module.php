<?php

declare(strict_types=1);

namespace app\modules\main;

use Yii;

/**
 * main module definition class.
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\main\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/main/' . $category, $message, $params, $language);
    }
}
