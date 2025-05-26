<?php

declare(strict_types=1);

namespace app\modules\seo\controllers\common;

use app\modules\seo\services\SeoService;
use app\modules\seo\services\CityService;

/**
 * Represents the base class for the category controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    protected $seoService;
    protected $cityService;

    public function __construct(
        $id,
        $module,
        SeoService $seoService,
        CityService $cityService,
        $config = []
    ) {
        $this->seoService = $seoService;
        $this->cityService = $cityService;

        parent::__construct($id, $module, $config);
    }
}
