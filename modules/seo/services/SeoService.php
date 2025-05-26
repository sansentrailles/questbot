<?php

declare(strict_types=1);

namespace app\modules\seo\services;

use app\custom\helpers\StringHelper;
use app\custom\services\base\BaseService;
use app\modules\seo\models\Seo as Model;
use app\modules\seo\repositories\SeoRepository as Repository;
use yii\base\Model as Form;

class SeoService extends BaseService
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

    public function getSeo(string $section, int $refId = 0)
    {
        $seo = $this->repository->findSeo($section, $refId);
        if ($seo) {
            return $seo;
        }

        return new Model();
    }

    public function prepareSeo(Model $model, array $masks)
    {
        foreach ($masks as $item) {
            $model->title = StringHelper::mb_str_replace($item['title'], $item['form'], (string)$model->title);
            $model->keywords = StringHelper::mb_str_replace($item['title'], $item['form'], (string)$model->keywords);
            $model->description = StringHelper::mb_str_replace($item['title'], $item['form'], (string)$model->description);
        }

        return $model;
    }
}
