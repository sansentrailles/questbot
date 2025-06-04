<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use app\custom\services\base\BaseService;
use app\modules\quests\models\UserProgress as Model;
use app\modules\quests\repositories\UserProgressRepository as Repository;
use yii\base\Model as Form;
use app\modules\quests\forms\backend\UserProgressForm;

class UserProgressService extends BaseService
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

    public function getProgress(int $userId, ?int $questId = null)
    {
        return $this->repository->getProgress($userId, $questId);
    }

    public function createProgress(int $userId, int $questId, $taskId)
    {
        $form = new UserProgressForm();
        $form->user_id = $userId;
        $form->quest_id = $questId;
        $form->current_task_id = $taskId;
        $form->is_completed = Model::STATE_NOT_COMPLETED;

        return $this->save($form);
    }

    public function updateProgress(Model $model)
    {
        $form = new UserProgressForm($model);
        // $form->current_task_id = $taskId;

        return $this->save($form);
    }

    public function completeQuest(Model $model)
    {
        $form = new UserProgressForm($model);
        $form->is_completed = Model::STATE_COMPLETED;

        return $this->save($form);
    }
}
