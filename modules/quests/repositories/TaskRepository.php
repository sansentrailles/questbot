<?php

declare(strict_types=1);

namespace app\modules\quests\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\quests\models\Task as Model;

class TaskRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function getNext(Model $model)
    {
        $query = $this->model::find()
            ->andWhere([
                'is_visible' => Model::STATUS_VISIBLE,
                'quest_id' => $model->quest->id,
            ])
            ->orderBy(['ord' => SORT_ASC])
            ->limit(1);

        $next = (clone $query)
            ->andWhere(['or', ['>', 'ord', $model->ord], ['and', ['=', 'ord', $model->ord], ['>', 'id', $model->id]]])
            ->one();

        return $next;
    }
}
