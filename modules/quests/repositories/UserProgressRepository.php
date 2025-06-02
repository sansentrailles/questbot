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
    public function getProgress(int $userId, int $questId)
    {
        return $this->model::find()->where([
            'user_id' => $userId,
            'quest_id' => $questId,
            'is_complted' => Model::STATE_NOT_COMPLETED
        ])->one();
    }
}
