<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

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
            [['value'], 'safe'],
        ]);
    }
}
