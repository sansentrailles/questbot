<?php

declare(strict_types=1);

namespace app\modules\main\services;

use app\custom\services\base\BaseService;
use app\modules\main\forms\backend\EmployeeForm as Form;
use app\modules\main\models\Employee as Model;
use app\modules\main\repositories\EmployeeRepository as Repository;

class EmployeeService extends BaseService
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

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function toggleVisible($id)
    {
        $model = $this->repository->find($id);
        $state = $model->toggleVisible();
        $this->repository->save($model);

        return $state;
    }

    public function getVisible()
    {
        return $this->repository->getVisible();
    }
}
