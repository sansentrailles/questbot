<?php

declare(strict_types=1);

namespace app\modules\guide\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\guide\models\GuideChapter as Model;

class GuideChapterRepository extends BaseRepository
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
