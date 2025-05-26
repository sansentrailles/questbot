<?php

declare(strict_types=1);

namespace app\modules\user\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\user\models\Permission as Model;

class PermissionRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function findByName($name)
    {
        return $this->model::findOne(['name' => $name]);
    }
}
