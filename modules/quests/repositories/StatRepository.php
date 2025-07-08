<?php

declare(strict_types=1);

namespace app\modules\quests\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quests\models\Stat as Model;

class StatRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getActualStat($userId, $questId)
    {
        $query = $this->model::find()
            ->andWhere([
                'user_id' => $userId,
                'quest_id' => $questId,
            ]);

        $query->andWhere('`finish` is null or `finish` = 0');

        return $query->one();
    }

    public function getStat($userId, $questId)
    {
        $query = $this->model::find()
            ->andWhere([
                'user_id' => $userId,
            ]);

        if ((int) $questId > 0) {
            $query->andWhere([
                'quest_id' => $questId,
            ]);
        }

        $query->andWhere('`finish` is null');
        
        return $query->one();
    }
}
