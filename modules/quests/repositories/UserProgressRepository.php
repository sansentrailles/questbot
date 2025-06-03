<?php

declare(strict_types=1);

namespace app\modules\quests\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quests\models\UserProgress as Model;

class UserProgressRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    // TODO: Возможно добавить проверку даты
    // TODO: Возможно сделать выбор нескольких квестов
    public function getProgress(int $userId, ?int $questId = null)
    {
        $query = $this->model::find()
            ->andWhere([
                'user_id' => $userId,
                'is_completed' => Model::STATE_NOT_COMPLETED
            ]);

        if ((int) $questId > 0) {
            $query->andWhere([
                'quest_id' => $questId,
            ]);
        }
        
        return $query->one();
    }
}
