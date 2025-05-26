<?php

declare(strict_types=1);

namespace app\modules\settings\models\traits;

use app\modules\settings\Module;

trait SettingAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('common', 'ID'),
            'title' => Module::t('common', 'SETTING_TITLE'),
            'desc' => Module::t('common', 'SETTING_DESC'),
            'group_id' => Module::t('common', 'SETTING_GROUP_ID'),
            'key' => Module::t('common', 'SETTING_KEY'),
            'type' => Module::t('common', 'SETTING_TYPE'),
            'type_id' => Module::t('common', 'SETTING_TYPE'),
            'event_name' => Module::t('common', 'SETTING_EVENT_NAME'),
            'is_multiple' => Module::t('common', 'SETTING_IS_MULTIPLE'),
            'created_at' => Module::t('common', 'SETTING_CREATED_AT'),
            'updated_at' => Module::t('common', 'SETTING_UPDATED_AT'),
        ];
    }
}
