<?php

declare(strict_types=1);

namespace app\modules\settings\controllers\common;

use app\custom\controllers\Controller as BaseController;
use app\modules\settings\services\SettingGroupService;
use app\modules\settings\services\SettingService;

/**
 * Represents the base class for the settings controllers.
 */
abstract class Controller extends BaseController
{
    protected $settingsService;
    protected $settingsGroupService;
    protected $settingsValueService;

    public function __construct(
        $id,
        $module,
        SettingService $settingsService,
        SettingGroupService $settingsGroupService,
        $config = []
    ) {
        $this->settingsService      = $settingsService;
        $this->settingsGroupService = $settingsGroupService;

        parent::__construct($id, $module, $config);
    }
}
