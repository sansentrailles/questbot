<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use yii\base\Model as Form;
use app\custom\services\base\BaseService;
use app\modules\quests\models\Stat as Model;
use app\modules\quests\forms\backend\StatForm;
use app\modules\quests\repositories\StatRepository as Repository;

class StatService extends BaseService
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

    public function createStat($userId, $questId)
    {
        $form = new StatForm();
        $form->user_id = $userId;
        $form->quest_id = $questId;
        $form->start = time();

        return $this->save($form);
    }

    public function updateStat($id)
    {

    }

    public function getActualStat($userId, $questId)
    {
        return $this->repository->getActualStat($userId, $questId);
    }
}
