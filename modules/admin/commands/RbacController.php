<?php

declare(strict_types=1);

namespace app\modules\admin\commands;

use app\modules\admin\rbac\Rbac as AdminRbac;
use Yii;
use yii\console\Controller;

/**
 * RBAC generator.
 */
class RbacController extends Controller
{
    /**
     * Generates roles.
     */
    public function actionInit(): void
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $adminPanel = $auth->createPermission(AdminRbac::PERMISSION_ADMIN_PANEL);
        $adminPanel->description = 'Admin panel';
        $auth->add($adminPanel);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $dev = $auth->createRole('dev');
        $dev->description = 'Developer';
        $auth->add($dev);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPanel);
        $auth->addChild($dev, $admin);

        $this->stdout('Done!' . PHP_EOL);
    }
}
