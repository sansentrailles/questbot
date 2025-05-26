<?php

declare(strict_types=1);

namespace app\modules\settings\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\settings\models\SettingStringValue as Model;

class SettingStringValueRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }
}
