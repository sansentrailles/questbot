<?php

declare(strict_types=1);

namespace app\custom\services\base;

use app\custom\helpers\StorageFileHelper;
use app\custom\interfaces\annotations\Fileable;
use app\custom\interfaces\annotations\Sortable;
use app\custom\services\transaction\TransactionManager;
use Exception;
use ReflectionClass;
use yii\base\Model;

abstract class BaseService
{
    protected $repository;
    protected $transactionManager;

    public function __construct(TransactionManager $transactionManager)
    {
        $repositoryClass = $this->getRepositoryClass();
        $this->repository = new $repositoryClass();

        $this->transactionManager = $transactionManager;
    }

    abstract public function getRepositoryClass();
    abstract public function create(Model $form);
    abstract public function edit(Model $form);

    public function save(Model $form)
    {
        if ($form->hasMethod('upload')) {
            $form->upload();
        }

        if ($form->isNewRecord) {
            return $this->create($form);
        }
        return $this->edit($form);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->repository->findOrFail($id);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getOrderedAll(array $condition)
    {
        return $this->repository->getOrderedAll($condition);
    }

    public function changeOrder($ords): void
    {
        foreach ($ords as $id => $ord) {
            try {
                $model = $this->repository->find((int)$id);
            } catch (Exception $e) {
                continue;
            }
            $model->setOrder((int)$ord);
            $this->repository->save($model);
        }
    }

    public function delete($id): void
    {
        $model = $this->repository->find($id);
        if ($this->isFileable($model)) {
            $this->removeFiles($model);
        }
        $this->repository->delete($model);
    }

    public function isFileable(Model $model)
    {
        return $this->hasInterface($model, Fileable::class);
    }

    public function isSortable(Model $model)
    {
        return $this->hasInterface($model, Sortable::class);
    }

    protected function removeFiles(Fileable $model): void
    {
        $files = $model->getNestedFiles();
        StorageFileHelper::removeFiles($files);
    }

    private function hasInterface($model, $interface)
    {
        return \array_key_exists($interface, (new ReflectionClass($model))->getInterfaces());
    }
}
