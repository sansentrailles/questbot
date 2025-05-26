<?php

declare(strict_types=1);

namespace app\modules\settings\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\settings\models\SettingValue as Model;

class SettingValueRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function findActive()
    {
        return $this->model::find()
            ->orderBy(['title' => SORT_DESC])
            ->all();
    }
}
