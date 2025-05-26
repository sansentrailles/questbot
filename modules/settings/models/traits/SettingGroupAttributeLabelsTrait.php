<?php

declare(strict_types=1);

namespace app\modules\settings\models\traits;

use app\modules\settings\Module;

trait SettingGroupAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => Module::t('common', 'ID'),
            'title' => Module::t('common', 'SETTING_GROUP_TITLE'),
            'desc'  => Module::t('common', 'SETTING_GROUP_DESC'),
            'name'  => Module::t('common', 'SETTING_GROUP_NAME'),
        ];
    }
}
