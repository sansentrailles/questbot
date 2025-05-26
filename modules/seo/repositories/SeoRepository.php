<?php

declare(strict_types=1);

namespace app\modules\seo\repositories;

use app\custom\services\base\BaseRepository;
use app\modules\seo\models\Seo as Model;

class SeoRepository extends BaseRepository
{
    public function getModelClass(): void
    {
        $this->model = Model::class;
    }

    public function findSeo(string $section, int $refId = 0)
    {
        $query = Model::find()
            ->where('section = :section', [':section' => $section]);

        $query->andWhere('ref_id = :refId', [':refId' => $refId]);
        // if ($refId > 0) {            
        // }

        $query->limit(1);

        // echo $query->createCommand()->rawSql; exit;

        return $query->one();
    }
}
