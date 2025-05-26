<?php

declare(strict_types=1);

namespace app\modules\settings\models\traits;

use app\modules\settings\Module;

trait SettingValueAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('common', 'ID'),
            'value' => Module::t('common', 'SETTING_VALUE'),
        ];
    }
}
