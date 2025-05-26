<?php

declare(strict_types=1);

namespace app\modules\settings\forms\backend;

use app\custom\files\BaseFile;
use app\custom\traits\common\form\UploadFilesTrait;
use app\modules\settings\models\SettingUploadedFileValue;
use yii\helpers\ArrayHelper;

/**
 * SettingUploadedFileValueForm is the model behind the setting value form.
 */
class SettingUploadedFileValueForm extends SettingValueForm
{
    use UploadFilesTrait;

    public $settingFile;
    public $valueFile;

    protected $settingValue;

    public function __construct(SettingUploadedFileValue $settingValue = null, $config = [])
    {
        $this->settingFile = new BaseFile('settingFile');
        $this->settingValue = $settingValue;
        parent::__construct($settingValue, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['value'], 'safe'],
            [['valueFile'], 'file', 'skipOnEmpty' => true],
        ]);
    }

    public function getUploadOptions()
    {
        return [
            'valueFile' => [
                'value' => [
                    'transform' => [
                        $this->settingFile->save(),
                    ],
                ],
            ],
        ];
    }
}
