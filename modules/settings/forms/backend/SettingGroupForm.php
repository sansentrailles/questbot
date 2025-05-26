<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

use app\modules\settings\models\SettingGroup;
use app\modules\settings\models\traits\SettingGroupAttributeLabelsTrait;
use yii\base\Model;

/**
 * SettingGroupForm is the model behind the setting form.
 */
class SettingGroupForm extends Model
{
    use SettingGroupAttributeLabelsTrait;

    public $id;
    public $title;
    public $desc;
    public $name;

    private $settingGroup;

    public function __construct(SettingGroup $settingGroup = null, $config = [])
    {
        $this->settingGroup = $settingGroup;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->settingGroup) {
            return;
        }

        $this->id    = $this->settingGroup->id;
        $this->title = $this->settingGroup->title;
        $this->desc  = $this->settingGroup->desc;
        $this->name  = $this->settingGroup->name;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Необходимо указать имя группы'],
            [['title'], 'required', 'message' => 'Необходимо указать название параметра'],
            [['name'], 'unique', 'targetClass' => SettingGroup::class, 'message' => 'Название группы должно быть уникальным. Значние "{value}" уже используется.', 'filter' => ['!=', 'id', $this->id]],
            [['name', 'title'], 'string', 'max' => 255],
            [['name'], 'filter', 'filter' => static fn ($value) => preg_replace('/\s+/', '-', $value)],
            [['desc'], 'string'],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->settingGroup) {
            return false;
        }

        return true;
    }
}
