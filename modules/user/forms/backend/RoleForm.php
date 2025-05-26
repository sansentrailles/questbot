<?php

declare(strict_types=1);

namespace app\modules\user\forms\backend;

use app\modules\user\Module;
use Yii;
use yii\base\Model;
use yii\rbac\Role;

/**
 * RoleForm is the model behind the role item form.
 */
class RoleForm extends Model
{
    public $name;
    public $description;

    private $_permissions = [];

    private $role;

    public function __construct(Role $role = null, $config = [])
    {
        $this->role = $role;

        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->role) {
            return;
        }

        $this->name        = $this->role->name;
        $this->description = $this->role->description;
    }

    public function reinit(): void
    {
        if (!$this->role) {
            return;
        }

        $this->role->name = $this->name;
        $this->role->description = $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 255],
            ['name', 'required'],

            ['description', 'string', 'max' => 255],
            ['description', 'required'],

            [['permissions'], 'safe'],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->role) {
            return false;
        }

        return true;
    }

    public function getRole()
    {
        if ($this->role === null) {
            $this->role = new Role();
        }

        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('common', 'ROLE_NAME'),
            'description' => Module::t('common', 'ROLE_DESCRIPTION'),
            'permissions' => Module::t('common', 'PERMISSIONS'),
        ];
    }

    public function getPermissions()
    {
        $auth = Yii::$app->authManager;

        if (!empty($this->_permissions)) {
            return $this->_permissions;
        }

        if ($this->role) {
            $permissions = $auth->getPermissionsByRole($this->role->name);
            // BaseHtml::getAttributeValue is looking for index resides in []
            // in this case it wiil be ''
            // because the attribute name is flags[]
            return ['' => array_map(static fn ($permission) => $permission->name, $permissions)];
        }

        return [];
    }

    public function setPermissions($value): void
    {
        $this->_permissions = $value;
    }
}
