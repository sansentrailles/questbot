<?php

declare(strict_types=1);

namespace app\modules\settings\models;

use app\modules\settings\forms\backend\SettingGroupForm as Form;
use app\modules\settings\models\traits\SettingGroupAttributeLabelsTrait;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $desc
 */
class SettingGroup extends \yii\db\ActiveRecord
{
    use SettingGroupAttributeLabelsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_groups';
    }

    public static function add(Form $form)
    {
        $model = new self();

        $model->title = $form->title;
        $model->desc  = $form->desc;
        $model->name  = $form->name;

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->title = $form->title;
        $this->desc  = $form->desc;
        $this->name  = $form->name;
    }

    public function getSettings()
    {
        return $this->hasMany(Setting::class, ['group_id' => 'id']);
    }
}
