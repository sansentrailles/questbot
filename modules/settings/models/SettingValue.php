<?php

declare(strict_types=1);

namespace app\modules\settings\models;

use app\modules\settings\files\SettingFile;
use app\modules\settings\forms\backend\SettingValueForm;
use app\modules\settings\models\traits\SettingValueAttributeLabelsTrait;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property int $setting_id
 * @property string $value
 */
class SettingValue extends \yii\db\ActiveRecord
{
    use SettingValueAttributeLabelsTrait;

    public static function add(SettingValueForm $form)
    {
        $class = static::class;
        $model = new $class();

        $model->setting_id = $form->setting_id;
        $model->value  = $form->value;

        return $model;
    }

    public function edit(SettingValueForm $form): void
    {
        $this->value  = $form->value;
    }

    public function getSetting()
    {
        return $this->hasOne(Setting::class, ['id' => 'setting_id']);
    }

    public function setSettingId($settingId): void
    {
        $this->setting_id = $settingId;
    }

    public function getOutputValue()
    {
        return $this->value;
    }

    // public function getOption()
    // {
    //     if($this->setting->type_id != Setting::TYPE_UPLOADED_FILE) {
    //         return $this->value;
    //     }

    //     return $this->getFilePath();
    // }

    // private function getFilePath()
    // {
    //     if($this->value) {
    //         return SettingFile::getPath($this->value);
    //     }

    //     return null;
    // }
}
