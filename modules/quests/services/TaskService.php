<?php

declare(strict_types=1);

namespace app\modules\quests\services;

use app\custom\helpers\StorageFileHelper;
use app\custom\services\base\BaseService;
use app\modules\quests\models\Task as Model;
use app\modules\quests\repositories\TaskRepository as Repository;
use yii\base\Model as Form;

class TaskService extends BaseService
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

    public function deleteImage($id): void
    {
        $model = $this->repository->find($id);
        $files = $model->getImageFiles();
        StorageFileHelper::removeFiles($files);
        $model->image = null;
        $this->repository->save($model);
    }

    public function deleteImageInfo($id): void
    {
        $model = $this->repository->find($id);
        $files = $model->getImageInfoFiles();
        StorageFileHelper::removeFiles($files);
        $model->image_info = null;
        $this->repository->save($model);
    }

    public function toggleVisible($id)
    {
        $model = $this->repository->find($id);
        $state = $model->toggleVisible();
        $this->repository->save($model);

        return $state;
    }

    public function getNext(Model $model)
    {
        return $this->repository->getNext($model);
    }
}
