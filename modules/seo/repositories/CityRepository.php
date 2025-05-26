<?php

declare(strict_types=1);

namespace app\modules\seo\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\seo\models\City as Model;

class CityRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getVisible()
    {
        return $this->model::find()
            ->andWhere(['is_visible' => Model::STATUS_VISIBLE])
            ->orderBy(['ord' => SORT_ASC])
            ->all();
    }

    public function getByCode(string $code)
    {
        return $this->model::findOne(['code' => $code]);
    }

    public function getDefault()
    {
        return $this->model::findOne(['is_default' => Model::STATE_DEFAULT]);
    }
}
