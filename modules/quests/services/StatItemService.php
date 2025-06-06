<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use yii\base\Model as Form;
use app\custom\services\base\BaseService;
use app\modules\quests\models\StatItem as Model;
use app\modules\quests\forms\backend\StatItemForm;
use app\modules\quests\repositories\StatItemRepository as Repository;

class StatItemService extends BaseService
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

    public function saveStatItem(Model $model)
    {
        $form = new StatItemForm($model);

        return $this->save($form);
    }
}
