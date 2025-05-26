<?php

declare(strict_types=1);

namespace app\modules\settings\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\settings\models\Setting as Model;

class SettingRepository extends BaseRepository
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

    public function getValues(int $groupId, string $key)
    {
        $q = $this->model::find()
            ->joinWith('group')
            ->where(['setting_groups.id' => $groupId])
            ->andWhere(['key' => $key]);
        // echo $q->createCommand()->rawSql;

        return $q->one();
    }
}
