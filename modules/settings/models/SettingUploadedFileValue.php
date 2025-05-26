<?php

declare(strict_types=1);

namespace app\modules\settings\models;

use app\custom\files\BaseFile;
use app\custom\interfaces\annotations\Fileable;
use app\modules\settings\models\traits\SettingValueAttributeLabelsTrait;

/**
 * This is the model class for table "setting_file_value".
 *
 * @property int $id
 * @property int $setting_id
 * @property string $value
 *
 * @property Setting $setting
 */
class SettingUploadedFileValue extends SettingValue implements Fileable
{
    use SettingValueAttributeLabelsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_file_value';
    }

    public function getValueFiles()
    {
        $files = [];
        if ($this->value) {
            $files[] = [
                'bucket' => (new BaseFile('settingFile'))->getBucket(),
                'file' => $this->value,
            ];
        }
        return $files;
    }

    public function getNestedFiles(): array
    {
        $files = [];
        return array_merge($files, $this->getValueFiles());
    }

    public function getOutputValue()
    {
        if ($this->value) {
            return (new BaseFile('settingFile'))->getPath($this->value);
        }

        return null;
    }
}
