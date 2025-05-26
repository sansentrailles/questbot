<?php

declare(strict_types=1);

namespace app\modules\settings\models;

use app\modules\settings\models\traits\SettingValueAttributeLabelsTrait;

/**
 * This is the model class for table "setting_text_value".
 *
 * @property int $id
 * @property int $setting_id
 * @property string $value
 *
 * @property Setting $setting
 */
class SettingTextValue extends SettingValue
{
    use SettingValueAttributeLabelsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_text_value';
    }
}
