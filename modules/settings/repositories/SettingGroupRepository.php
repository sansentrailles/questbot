<?php

declare(strict_types=1);

namespace app\modules\settings\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\settings\models\SettingGroup as Model;

class SettingGroupRepository extends BaseRepository
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

    public function findByName(string $name)
    {
        return $this->model::find()
            ->where(['name' => $name])
            ->one();
    }
}
