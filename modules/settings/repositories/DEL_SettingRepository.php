<?php

declare(strict_types=1);

namespace app\modules\settings\repositories;

use app\modules\settings\models\Setting;
use app\modules\settings\repositories\exceptions\NotFoundException;
use RuntimeException;

class DEL_SettingRepository
{
    /**
     * @param mixed $id
     * @return Setting
     * @throws NotFoundException
     */
    public function find($id)
    {
        if (!$setting = Setting::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $setting;
    }

    public function add(Setting $setting): void
    {
        if (!$setting->getIsNewRecord()) {
            throw new RuntimeException('Adding existing model.');
        }
        if (!$setting->insert(false)) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function save(Setting $setting): void
    {
        if ($setting->getIsNewRecord()) {
            throw new RuntimeException('Saving new model.');
        }
        if ($setting->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(Setting $setting): void
    {
        if (!$setting->delete()) {
            throw new RuntimeException('Deleting error.');
        }
    }

    /**
     * @param mixed $parentId
     * @return Setting
     */
    public function findByParentId($parentId)
    {
        return Setting::find()
            ->where(['parent_id' => $parentId])
            ->one();
    }

    public function getItemsCount($parentId)
    {
        $setting = Setting::find()
            ->where([
                'parent_id' => $parentId,
                'is_active' => Setting::STATUS_ACTIVE,
            ]);

        return \count($setting);
    }

    public function getSetting($group, $key)
    {
        return Setting::find()
            ->where([
                'group' => $group,
                'key' => $key,
            ])
            ->one();
    }

    public function getGroupSettings($group)
    {
        return Setting::find()
            ->where(['group' => $group])
            ->all();
    }
}
