<?php

declare(strict_types=1);

namespace app\modules\settings\services;

use app\custom\services\base\BaseService;
// use app\modules\settings\forms\backend\SettingUrlValueForm as Form;
use yii\base\Model as Form;
use app\modules\settings\models\SettingUrlValue as Model;
use app\modules\settings\repositories\SettingUrlValueRepository as Repository;

class SettingUrlValueService extends BaseService
{
    public function saveValues(array $forms): void
    {
        foreach ($forms as $form) {
            $this->save($form);
        }
    }

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
}
