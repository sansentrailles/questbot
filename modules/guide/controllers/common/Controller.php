<?php

declare(strict_types=1);

namespace app\modules\guide\controllers\common;

use app\modules\guide\services\GuideChapterService;

/**
 * Represents the base class for the guide controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    protected $guideChapterService;

    public function __construct(
        $id,
        $module,
        GuideChapterService $guideChapterService,
        $config = []
    ) {
        $this->guideChapterService = $guideChapterService;

        parent::__construct($id, $module, $config);
    }
}
