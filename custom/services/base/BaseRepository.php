<?php

declare(strict_types=1);

namespace app\custom\services\base;

use app\custom\services\base\exceptions\NotFoundException;
use RuntimeException;
use yii\db\ActiveRecord as Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->getModelClass();
    }

    abstract public function getModelClass();

    public function find($id)
    {
        return $this->model::findOne($id);
    }

    /**
     * @param mixed $id
     * @return Model
     * @throws NotFoundException
     */
    public function findOrFail($id)
    {
        if (!$model = $this->model::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $model;
    }

    public function add(Model $model): void
    {
        if (!$model->getIsNewRecord()) {
            throw new RuntimeException('Adding existing model.');
        }
        if (!$model->insert(false)) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function save(Model $model): void
    {
        if ($model->getIsNewRecord()) {
            throw new RuntimeException('Saving new model.');
        }
        if ($model->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(Model $model): void
    {
        if (!$model->delete()) {
            throw new RuntimeException('Deleting error.');
        }
    }

    public function getAll()
    {
        return $this->model::find()->all();
    }

    public function getOrderedAll(array $condition)
    {
        return $this->model::find()
            ->orderBy($condition)
            ->all();
    }
}
