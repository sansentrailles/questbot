<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

use app\modules\settings\models\Setting;
use app\modules\settings\models\SettingValue;
use app\modules\settings\models\traits\SettingValueAttributeLabelsTrait;
use yii\base\Model;

/**
 * SettingValueForm is the model behind the setting value form.
 */
class SettingValueForm extends Model
{
    use SettingValueAttributeLabelsTrait;

    public $id;
    public $setting_id;
    public $value;

    protected $settingValue;

    public function __construct(SettingValue $settingValue = null, $config = [])
    {
        $this->settingValue = $settingValue;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->settingValue) {
            return;
        }

        $this->id         = $this->settingValue->id;
        $this->setting_id = $this->settingValue->setting_id;
        $this->value      = $this->settingValue->value;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_id'], 'integer'],
            [['setting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Setting::class, 'targetAttribute' => ['setting_id' => 'id']],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->settingValue) {
            return false;
        }

        return true;
    }

    public function getSettingValue()
    {
        if ($this->settingValue === null) {
            $this->settingValue = new SettingValue();
        }

        return $this->settingValue;
    }

    public function getPrimaryKey()
    {
        if ($this->settingValue) {
            return $this->settingValue->primaryKey;
        }

        return null;
    }

    public function setSettingId($settingId): void
    {
        $this->setting_id = $settingId;
    }
}
