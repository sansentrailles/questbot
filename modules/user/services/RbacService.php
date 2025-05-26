<?php

declare(strict_types=1);

namespace app\modules\user\services;

use app\modules\user\forms\backend\PermissionForm;
use app\modules\user\forms\backend\RoleForm;
use Yii;

class RbacService
{
    private $auth;

    public function __construct()
    {
        $this->auth = Yii::$app->authManager;
    }

    public function createPermission(PermissionForm $form)
    {
        $permission = $this->auth->createPermission($form->name);
        $permission->description = $form->description;

        return $this->auth->add($permission);
    }

    public function createRole(RoleForm $form): void
    {
        $role = $this->auth->createRole($form->name);
        $role->description = $form->description;

        $this->auth->add($role);
        $this->assignPermissions($role, $form->permissions);
    }

    public function updateRole(RoleForm $form)
    {
        $form->reinit();
        $this->assignPermissions($form->role, $form->permissions);

        return $this->auth->update($form->name, $form->role);
    }

    public function assignPermissions($role, array $permissions): void
    {
        $this->auth->removeChildren($role);
        foreach ($permissions as $item) {
            $permission = $this->getPermission($item);
            if ($permission === null) {
                continue;
            }

            $this->auth->addChild($role, $permission);
        }
    }

    public function assignRoles($userId, array $roles)
    {
        if (\count($roles) === 0) {
            return false;
        }

        $this->auth->revokeAll($userId);

        foreach ($roles as $roleName) {
            $role = $this->getRole($roleName);
            if ($role === null) {
                continue;
            }

            $this->auth->assign($role, $userId);
        }

        return true;
    }

    public function getPermission(string $name)
    {
        return $this->auth->getPermission($name);
    }

    public function getRole(string $name)
    {
        return $this->auth->getRole($name);
    }

    /**
     * $object 	yii\rbac\Role|yii\rbac\Permission|yii\rbac\Rule.
     * @param mixed $obj
     */
    public function delete($obj)
    {
        return $this->auth->remove($obj);
    }

    public function getPermissions()
    {
        return $this->auth->getPermissions();
    }

    public function getRoles()
    {
        return $this->auth->getRoles();
    }

    public function getUserRoles($userId)
    {
        return $this->auth->getRolesByUser($userId);
    }
}
