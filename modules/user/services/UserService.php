<?php

declare(strict_types=1);

namespace app\modules\user\services;

use app\custom\services\base\BaseService;
use app\modules\user\forms\backend\UserForm as Form;
use app\modules\user\models\User as Model;
use app\modules\user\repositories\UserRepository as Repository;

class UserService extends BaseService
{
    // public function save(Form $form)
    // {
    //     if ($form->hasMethod('upload')) {
    //         $form->upload();
    //     }

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
        $model = $this->repository->find($form->id);
        $model->edit($form);
        $this->repository->save($model);

        return $model;
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function getUsersForDropdown()
    {
        $users = $this->getAll();
        $result = [];

        foreach ($users as $user) {
            $result[$user->id] = $user->fullname;
        }

        return $result;
    }

    public function getTodayBirthdays()
    {
        return $this->repository->getTodayBirthdays();
    }

    public function getByEmail($email)
    {
        return $this->repository->getByEmail($email);
    }
}
