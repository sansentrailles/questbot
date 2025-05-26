<?php

declare(strict_types=1);

namespace app\modules\settings\services;

use app\custom\services\base\BaseService;
// use app\modules\settings\forms\backend\SettingForm as Form;
use yii\base\Model as Form;
use app\modules\settings\models\Setting as Model;
use app\modules\settings\repositories\SettingRepository as Repository;
use Yii;

class SettingService extends BaseService
{
    public function create(Form $form)
    {
        $model = Model::add($form);
        $this->repository->add($model);
        return $model;
    }

    public function edit(Form $form)
    {
        $model = $this->repository->find($form->id);
        $model->edit($form);
        $this->repository->save($model);

        return $model;
    }

    public function getAll()
    {
        return $this->repository->findActive();
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function getValueForms(Model $setting)
    {
        $values = $setting->values;

        if (!$values) {
            $valueModel = $this->createSettingValueForm($setting->type_id);
            $valueModel->setSettingId($setting->id);
            return [$valueModel];
        }

        $result = [];
        foreach ($values as $valueModel) {
            $valueModel->setSettingId($setting->id);
            $result[$valueModel->id] = $this->createSettingValueForm($setting->type_id, $valueModel);
        }

        return $result;
    }

    public function createSettingValueForm($typeId, $model = null)
    {
        $modelName = '\app\modules\settings\forms\backend\\' . $this->getFormName($typeId);

        return new $modelName($model);
    }

    public function getFormName($typeId)
    {
        return $this->getModelName($typeId) . 'Form';
    }

    public function getValueService($typeId)
    {
        if (isset(Model::getTypes()[$typeId])) {
            return Yii::$container->get(Model::getTypes()[$typeId]['service']);
        }

        return null;
    }

    public function getValues($groupId, $key)
    {
        return $this->repository->getValues($groupId, $key);
    }

    public function getCacheKey($id)
    {
        $params = explode('.', $id);
        $groupName = $params[0];
        $key = $params[1] ?? null;

        $cacheKey = 'setting-' . $groupName;
        if ($key) {
            $cacheKey .= '-' . $key;
        }

        return $cacheKey;
    }

    public function clearCache(Model $setting): void
    {
        $cache = Yii::$app->cache;
        $groupName = $setting->group->name;

        $groupCacheKey = 'setting-' . $groupName;
        $cacheKey = 'setting-' . $groupName . '-' . $setting->key;

        $cache->delete($groupCacheKey);
        $cache->delete($cacheKey);
    }

    public function tirggerEvent(string $eventName)
    {
        if ($eventName === '') {
            return false;
        }

        // Yii::$app->eventHandler->trigger($eventName);
        Yii::$app->trigger($eventName);
    }

    private function getModelValueClass($typeId)
    {
        return 'app\modules\settings\models\\' . $this->getModelName($typeId);
    }

    private function getModelName($typeId)
    {
        $typeName = Model::getTypes()[$typeId]['name'];
        $parts = explode('_', $typeName);
        $parts = array_map(static fn ($item) => ucfirst($item), $parts);

        return 'Setting' . implode('', $parts) . 'Value';
    }
}
