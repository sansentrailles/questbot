<?php

declare(strict_types=1);

namespace app\modules\settings\components;

use app\modules\settings\models\Setting as SettingModel;
use app\modules\settings\services\SettingGroupService;
use app\modules\settings\services\SettingService;
use Yii;
use yii\base\Component;

class Setting extends Component
{
    public $time;
    public $caching = false;
    private $settingService;
    private $settingGroupService;

    public function __construct(
        SettingService $settingService,
        SettingGroupService $settingGroupService,
        $config = []
    ) {
        $this->settingService = $settingService;
        $this->settingGroupService = $settingGroupService;

        parent::__construct($config);
    }

    public function get(string $id, mixed $default = null)
    {
        $cache = Yii::$app->cache;
        $params = explode('.', $id);

        $groupName = $params[0];
        $key = $params[1] ?? null;

        if ($this->caching) {
            $cacheKey = $this->settingService->getCacheKey($id);
            return $cache->getOrSet($cacheKey, function () use ($groupName, $key, $default) {
                $vals = $this->getSettingValues($groupName, $key);
                if (!$vals && $default) {
                    $vals = $default;
                }
                return $vals;
            }, $this->time);
        }

        return $this->getSettingValues($groupName, $key);
    }

    public function getValuesByGroup(string $groupName): ?array
    {
        $group = $this->settingGroupService->findByName($groupName);
        if ($group === null) {
            return null;
        }

        $settings = $group->settings;
        if ($settings === null || \count($settings) === 0) {
            return null;
        }

        $result = [];
        foreach ($settings as $setting) {
            $values = $setting->values;
            if ($setting->is_multiple === SettingModel::STATE_MULTIPLE) {
                $result[] = $this->getValues($values);
            } else {
                $valueItem = current($values);
                $result[] = $valueItem->outputValue;
            }
        }

        return $result;
    }

    public function getValue(string $groupName, string $key)
    {
        $group = $this->settingGroupService->findByName($groupName);
        if ($group === null) {
            return null;
        }

        $setting = $this->settingService->getValues($group->id, $key);
        if ($setting === null) {
            return null;
        }
        $values = $this->getValues($setting->values);

        if ($setting->is_multiple === SettingModel::STATE_NOT_MULTIPLE) {
            return current($values);
        }

        return $values;
    }

    private function getSettingValues($groupName, $key = null)
    {
        if ($key === null) {
            $values = $this->getValuesByGroup($groupName);
        } else {
            $values = $this->getValue($groupName, $key);
        }

        return $values;
    }

    private function getValues(array $values)
    {
        $result = [];
        foreach ($values as $valueItem) {
            $result[] = $valueItem->outputValue;
        }

        return $result;
    }
}
