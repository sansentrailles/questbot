<?php

declare(strict_types=1);

namespace app\modules\seo\services;

use app\custom\services\base\BaseService;
use app\modules\seo\models\City as Model;
use app\modules\seo\repositories\CityRepository as Repository;
use yii\base\Model as Form;

class CityService extends BaseService
{
    public function save(Form $form)
    {
        $form->masks = $this->setMasks($form);
        return parent::save($form);
    }

    public function create(Form $form)
    {
        $model = Model::add($form);
        $transaction = $this->transactionManager->begin();
        try {
            if ($model->is_default) {
                Model::dropDefaultStates();
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
            if ($model->is_default) {
                Model::dropDefaultStates();
            }
            $this->repository->save($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $model;
    }

    // public function create(Form $form)
    // {
    //     $model = Model::add($form);
    //     $this->repository->add($model);
    //     return $model;
    // }

    // public function edit(Form $form)
    // {
    //     $model = $this->repository->find($form->id);
    //     $model->edit($form);
    //     $this->repository->save($model);

    //     return $model;
    // }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function getVisible()
    {
        return $this->repository->getVisible();
    }

    public function toggleVisible($id)
    {
        $model = $this->repository->find($id);
        $state = $model->toggleVisible();
        $this->repository->save($model);

        return $state;
    }

    private function setMasks(Form $form):?string
    {
        $arrMasks = [];
        $titles = $form->masks_titles;

        if (is_null($titles)) {
            return null;
        }

        foreach ($titles as $index => $title) {
            if (isset($form->masks_forms[$index]) === false) {
                continue;
            }
            
            $arrMasks[] = [
                'title' => $title,
                'form' => $form->masks_forms[$index],
            ];
        }
        
        return json_encode($arrMasks);
    }

    public function getByCode(string $code)
    {
        return $this->repository->getByCode($code);
    }

    public function toggleDefault($id)
    {
        $model = $this->repository->find($id);

        // if ($model->is_default) {
        //     return null;
        // }

        $state = $model->toggleDefault();
        $transaction = $this->transactionManager->begin();
        try {
            Model::dropDefaultStates();
            $this->repository->save($model);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $state;
    }

    public function getDefault()
    {
        $city = $this->repository->getDefault();
        if ($city) {
            return $city;
        }

        $cities = $this->getOrderedAll(['title' => SORT_ASC]);
        if (count ($cities) > 0) {
            return $cities[0];
        }

        return [];
    }
}
