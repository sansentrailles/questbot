<?php

declare(strict_types=1);

namespace app\modules\settings\models;

use app\modules\settings\forms\backend\SettingForm;
use app\modules\settings\models\traits\SettingAttributeLabelsTrait;
use app\modules\settings\Module;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string $group
 * @property string $key
 * @property int $type_id
 * @property int $is_multiple
 * @property int $created_at
 * @property int $updated_at
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
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function add(SettingForm $model)
    {
        $setting = new self();

        $setting->title       = $model->title;
        $setting->desc        = $model->desc;
        $setting->group       = $model->group;
        $setting->key         = $model->key;
        $setting->type_id     = $model->type_id;
        $setting->is_multiple = $model->is_multiple;

        return $setting;
    }

    public function edit(SettingForm $model): void
    {
        $this->title       = $model->title;
        $this->desc        = $model->desc;
        $this->group       = $model->group;
        $this->key         = $model->key;
        $this->is_multiple = $model->is_multiple;
    }

    public function toggleMultiple()
    {
        return $this->is_multiple = !$this->is_multiple;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_STRING => ['label' => Module::t('common', 'SETTING_STRING'), 'name' => 'string', 'visible' => true],
            self::TYPE_TEXT => ['label' => Module::t('common', 'SETTING_TEXT'), 'name' => 'text', 'visible' => true],
            self::TYPE_FORMATED_TEXT => ['label' => Module::t('common', 'SETTING_FORMATED_TEXT'), 'name' => 'formated_text', 'visible' => true],
            self::TYPE_EMAIL => ['label' => Module::t('common', 'SETTING_EMAIL'), 'name' => 'email', 'visible' => true],
            self::TYPE_URL => ['label' => Module::t('common', 'SETTING_URL'), 'name' => 'url', 'visible' => true],
            self::TYPE_UPLOADED_FILE => ['label' => Module::t('common', 'SETTING_UPLOADED_FILE'), 'name' => 'uploaded_file', 'visible' => false],
            self::TYPE_SELECTED_FILE => ['label' => Module::t('common', 'SETTING_SELECTED_FILE'), 'name' => 'selected_file', 'visible' => true],
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
        return $this->hasMany(SettingValue::class, ['setting_id' => 'id']);
    }
}
