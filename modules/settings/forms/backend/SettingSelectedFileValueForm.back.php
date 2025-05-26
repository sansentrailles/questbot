<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

use app\modules\settings\models\Setting;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * SettingSelectedFileValueForm is the model behind the setting value form.
 */
class SettingSelectedFileValueForm extends SettingValueForm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['value', 'string', 'max' => 255],
        ]);
    }
}
