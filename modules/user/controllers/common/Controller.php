<?php

declare(strict_types=1);

namespace app\modules\user\controllers\common;

use app\modules\user\services\PermissionService;
use app\modules\user\services\RbacService;
use app\modules\user\services\UserService;

/**
 * Represents the base class for the user lang controllers.
 */
abstract class Controller extends \app\custom\controllers\Controller
{
    protected $userService;
    protected $permissionService;
    protected $rbacService;

    public function __construct(
        $id,
        $module,
        UserService $userService,
        PermissionService $permissionService,
        RbacService $rbacService,
        $config = []
    ) {
        $this->userService = $userService;
        $this->permissionService = $permissionService;
        $this->rbacService = $rbacService;

        parent::__construct($id, $module, $config);
    }
}
