<?php

declare(strict_types=1);

namespace app\modules\seo\controllers\common;

use app\modules\seo\services\CityService;
use Yii;

/**
 * Represents the base class for the controllers.
 */
abstract class RestController extends \yii\rest\Controller
{
    protected $cityService;

    public function __construct(
        $id,
        $module,
        $config = []
    ) {
        $container = Yii::$container;
        $this->cityService = $container->get(CityService::class);

        parent::__construct($id, $module, $config);
    }
}
