<?php

declare(strict_types=1);

namespace app\modules\settings\repositories;

use app\modules\settings\models\SettingValue;
use app\modules\settings\repositories\exceptions\NotFoundException;
use RuntimeException;

class DEL_SettingValueRepository
{
    /**
     * @param mixed $id
     * @return SettingValue
     * @throws NotFoundException
     */
    public function find($id)
    {
        if (!$settingValue = SettingValue::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $settingValue;
    }

    public function add(SettingValue $settingValue): void
    {
        if (!$settingValue->getIsNewRecord()) {
            throw new RuntimeException('Adding existing model.');
        }
        if (!$settingValue->insert(false)) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function save(SettingValue $settingValue): void
    {
        if ($settingValue->getIsNewRecord()) {
            throw new RuntimeException('Saving new model.');
        }
        if ($settingValue->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(SettingValue $settingValue): void
    {
        if (!$settingValue->delete()) {
            throw new RuntimeException('Deleting error.');
        }
    }

    public function deleteAllforSetting($settingId)
    {
        return SettingValue::deleteAll(['setting_id' => $settingId]);
    }
}
