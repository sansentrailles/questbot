<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

use app\modules\settings\models\Setting;
use app\modules\settings\models\SettingGroup;
use app\modules\settings\models\traits\SettingAttributeLabelsTrait;
use yii\base\Model;

/**
 * SettingForm is the model behind the setting form.
 */
class SettingForm extends Model
{
    use SettingAttributeLabelsTrait;

    public $id;
    public $title;
    public $desc;
    public $type_id;
    public $group_id;
    public $key;
    public $is_multiple;
    public $event_name;

    private $setting;

    public function __construct(Setting $setting = null, $config = [])
    {
        $this->setting = $setting;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->setting) {
            return;
        }

        $this->id          = $this->setting->id;
        $this->title       = $this->setting->title;
        $this->desc        = $this->setting->desc;
        $this->group_id    = $this->setting->group_id;
        $this->key         = $this->setting->key;
        $this->type_id     = $this->setting->type_id;
        $this->is_multiple = $this->setting->is_multiple;
        $this->event_name  = $this->setting->event_name;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_multiple'], 'integer'],
            [['group_id'], 'required', 'message' => 'Необходимо указать группу'],
            [['key'], 'required', 'message' => 'Необходимо указать ключ'],
            [['title'], 'required', 'message' => 'Необходимо указать название параметра'],
            // [['group'], 'unique', 'targetClass' => Setting::class, 'message' => 'Название группы должно быть уникальным. Значние "{value}" уже используется.', 'filter' => ['!=', 'id', $this->id]],
            [['key', 'title', 'event_name'], 'string', 'max' => 255],
            [['key'], 'filter', 'filter' => static fn ($value) => preg_replace('/\s+/', '-', $value)],
            [['desc'], 'string'],
            ['type_id', 'in', 'range' => array_keys(Setting::getTypes())],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SettingGroup::class, 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->setting) {
            return false;
        }

        return true;
    }

    public function setType($type_id): void
    {
        $this->type_id = $type_id;
    }

    // public function getValues()
    // {
    //     if($this->setting === null) {
    //         return [];
    //     }

    //     $settingValues = $this->setting->values;
    //     $values = [];
    //     foreach($settingValues as $settingValue) {
    //         $values[] = $settingValue->value;
    //     }

    //     return $values;
    // }
}
