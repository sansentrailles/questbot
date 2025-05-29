<?php

declare(strict_types=1);

namespace app\modules\quests\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quests\models\Quest as Model;

class QuestRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }
}
