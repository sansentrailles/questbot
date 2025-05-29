<?php

declare(strict_types=1);

namespace app\modules\quests;

use Yii;

/**
 * quests module definition class.
 */
class Module extends Yii\base\Module
{
    public $controllerNamespace = 'app\modules\quests\controllers';

    public function init(): void
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/quests/' . $category, $message, $params, $language);
    }
}
