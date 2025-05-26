<?php

declare(strict_types=1);

namespace app\modules\user\services;

use app\custom\services\base\BaseService;
use app\modules\user\forms\backend\PermissionForm as Form;
use app\modules\user\models\Permission as Model;
use app\modules\user\repositories\PermissionRepository as Repository;

class PermissionService extends BaseService
{
    // public function save(Form $form)
    // {
    //     if ($form->isNewRecord) {
    //         $model = $this->create($form);
    //     } else {
    //         $model = $this->edit($form);
    //     }

    //     return $model;
    // }

    public function create(Form $form)
    {
        $model = Model::add($form);
        $this->repository->add($model);
        return $model;
    }

    public function edit(Form $form)
    {
        $model = $this->repository->findByName($form->name);
        $model->edit($form);
        $this->repository->save($model);

        return $model;
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function findByName($name)
    {
        return $this->repository->findByName($name);
    }
}
