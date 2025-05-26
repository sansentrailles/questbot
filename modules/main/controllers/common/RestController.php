<?php

declare(strict_types=1);

namespace app\modules\main\controllers\common;

use app\modules\tyres\services\CategoryService;
use app\modules\pages\services\PageService;
use app\modules\seo\services\SeoService;
use app\modules\seo\services\CityService;
use Yii;

/**
 * Represents the base class for the controllers.
 */
abstract class RestController extends \yii\rest\Controller
{
    protected $categoryService;
    protected $pageService;
    protected $seoService;
    protected $cityService;

    public function __construct(
        $id,
        $module,
        $config = []
    ) {
        $container = Yii::$container;
        $this->categoryService = $container->get(CategoryService::class);
        $this->pageService = $container->get(PageService::class);
        $this->seoService = $container->get(SeoService::class);
        $this->cityService = $container->get(CityService::class);

        parent::__construct($id, $module, $config);
    }
}
