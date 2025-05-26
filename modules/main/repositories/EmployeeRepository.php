<?php

declare(strict_types=1);

namespace app\modules\main\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\main\models\Employee as Model;

class EmployeeRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getVisible()
    {
        return $this->model::find()
            ->andWhere('is_visible = ' . Model::STATUS_VISIBLE)
            ->orderBy(['ord' => SORT_ASC])
            ->all();
    }
}
