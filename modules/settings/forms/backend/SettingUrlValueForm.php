<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

use yii\helpers\ArrayHelper;

/**
 * SettingUrlValueForm is the model behind the setting value form.
 */
class SettingUrlValueForm extends SettingValueForm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['value', 'url', 'defaultScheme' => 'http', 'message' => 'Неверный формат URL'],
        ]);
    }
}
