<?php

declare(strict_types=1);

namespace app\modules\settings\models;

use app\modules\settings\forms\backend\SettingForm as Form;
use app\modules\settings\models\traits\SettingAttributeLabelsTrait;
use app\modules\settings\Module;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string $key
 * @property string $event_name
 * @property string $is_mupltiple
 * @property int $group_id
 * @property int $type_id
 *
 * @property SettingGroup $group
 * @property SettingValue[] $values
 */
class Setting extends \yii\db\ActiveRecord
{
    use SettingAttributeLabelsTrait;

    public const STATE_MULTIPLE = 1;
    public const STATE_NOT_MULTIPLE = 0;

    public const TYPE_STRING = 10;
    public const TYPE_TEXT = 20;
    public const TYPE_FORMATED_TEXT = 30;
    public const TYPE_EMAIL = 40;
    public const TYPE_URL = 50;
    public const TYPE_UPLOADED_FILE = 60; // https://yii2-cookbook.readthedocs.io/working-with-multiple-records/
    public const TYPE_SELECTED_FILE = 70;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    public static function add(Form $form)
    {
        $model = new self();

        $model->title       = $form->title;
        $model->desc        = $form->desc;
        $model->group_id    = $form->group_id;
        $model->key         = $form->key;
        $model->type_id     = $form->type_id;
        $model->is_multiple = $form->is_multiple;
        $model->event_name  = $form->event_name;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->title       = $form->title;
        $this->desc        = $form->desc;
        $this->group_id    = $form->group_id;
        $this->key         = $form->key;
        $this->type_id     = $form->type_id;
        $this->is_multiple = $form->is_multiple;
        $this->event_name  = $form->event_name;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_STRING => ['label' => Module::t('common', 'SETTING_STRING'), 'name' => 'string', 'visible' => true, 'service'=> 'settingStringValueService'],
            self::TYPE_TEXT => ['label' => Module::t('common', 'SETTING_TEXT'), 'name' => 'text', 'visible' => true, 'service' => 'settingTextValueService'],
            self::TYPE_FORMATED_TEXT => ['label' => Module::t('common', 'SETTING_FORMATED_TEXT'), 'name' => 'formated_text', 'visible' => true, 'service' => 'settingFormatedTextValueService'],
            self::TYPE_EMAIL => ['label' => Module::t('common', 'SETTING_EMAIL'), 'name' => 'email', 'visible' => true, 'service' => 'settingEmailValueService'],
            self::TYPE_URL => ['label' => Module::t('common', 'SETTING_URL'), 'name' => 'url', 'visible' => true, 'service' => 'settingUrlValueService'],
            self::TYPE_UPLOADED_FILE => ['label' => Module::t('common', 'SETTING_UPLOADED_FILE'), 'name' => 'uploaded_file', 'visible' => true, 'service' => 'settingUploadedFileValueService'],
            self::TYPE_SELECTED_FILE => ['label' => Module::t('common', 'SETTING_SELECTED_FILE'), 'name' => 'selected_file', 'visible' => true, 'service' => 'settingSelectedFileValueService'],
        ];
    }

    public static function getVisibleTypes()
    {
        return array_filter(static::getTypes(), static fn ($item) => $item['visible']);
    }

    public static function getTypesForDropDown()
    {
        $result = [];
        foreach (static::getTypes() as $k => $item) {
            $result[$k] = $item['label'];
        }

        return $result;
    }

    public function getValues()
    {
        $modelName = $this->getValueModelName();
        $class = 'app\modules\settings\models\\' . $modelName;
        return $this->hasMany($class, ['setting_id' => 'id']);
    }

    public function getGroup()
    {
        return $this->hasOne(SettingGroup::class, ['id' => 'group_id']);
    }

    public function getValueModelName()
    {
        $name = static::getTypes()[$this->type_id]['name'];

        $parts = explode('_', $name);
        $parts = array_map(static fn ($item) => ucfirst($item), $parts);

        $name = implode('', $parts);
        // if($parts) {
        //     $parts = array_map(function($item) {
        //         return ucfirst($item);
        //     }, $parts);

        //     $name = implode('', $parts);
        // } else {
        //     $name = ucfirst($name);
        // }

        return 'Setting' . implode('', $parts) . 'Value';
    }
}
