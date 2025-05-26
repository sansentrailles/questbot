<?php

declare(strict_types=1);

namespace app\modules\settings\services;

use app\custom\services\base\BaseService;
// use app\modules\settings\forms\backend\SettingGroupForm as Form;
use yii\base\Model as Form;
use app\modules\settings\models\SettingGroup as Model;
use app\modules\settings\repositories\SettingGroupRepository as Repository;

class SettingGroupService extends BaseService
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

    public function findByName(string $name)
    {
        return $this->repository->findByName($name);
    }
}
