<?php

declare(strict_types=1);

namespace app\modules\guide\services;

use app\custom\services\base\BaseService;
use app\modules\guide\forms\backend\GuideChapterForm;
use app\modules\guide\models\GuideChapter;
use app\modules\guide\repositories\GuideChapterRepository as Repository;

class GuideChapterService extends BaseService
{
    public function create(GuideChapterForm $model)
    {
        $guideChapter = GuideChapter::add($model);
        $this->repository->add($guideChapter);
        return $guideChapter;
    }

    public function edit(GuideChapterForm $model)
    {
        $guideChapter = $this->repository->find($model->id);
        $guideChapter->edit($model);
        $this->repository->save($guideChapter);

        return $guideChapter;
    }

    public function toggleVisible($id)
    {
        $guideChapter = $this->repository->find($id);
        $state = $guideChapter->toggleVisible();
        $this->repository->save($guideChapter);

        return $state;
    }

    public function getRepositoryClass()
    {
        return Repository::class;
    }

    public function getAll()
    {
        return $this->repository->getVisible();
    }
}
