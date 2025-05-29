<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use app\custom\services\base\BaseService;
use app\modules\quests\models\Answer as Model;
use app\modules\quests\repositories\AnswerRepository as Repository;
use yii\base\Model as Form;

class AnswerService extends BaseService
{
    public function create(Form $form)
    {
        $model = Model::add($form);
        $transaction = $this->transactionManager->begin();
        try {
            if ($model->is_right) {
                Model::dropRightStates();
            }
            $this->repository->add($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model;
    }

    public function edit(Form $form)
    {
        $model = $this->repository->find($form->id);

        $model->edit($form);
        $transaction = $this->transactionManager->begin();
        try {
            if ($model->is_right) {
                Model::dropRightStates();
            }
            $this->repository->save($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model;
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function toggleRight($id)
    {
        $model = $this->repository->find($id);

        // if ($model->is_correct) {
        //     return null;
        // }

        $state = $model->toggleRight();
        $transaction = $this->transactionManager->begin();
        try {
            Model::dropRightStates();
            $this->repository->save($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $state;
    }
}
