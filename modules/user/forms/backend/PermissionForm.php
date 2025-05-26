<?php

declare(strict_types=1);

namespace app\modules\user\forms\backend;

use app\modules\user\models\Permission;
use app\modules\user\models\traits\PermissionAttributeLabelsTrait;
use yii\base\Model;

/**
 * PermissionForm is the model behind the user item form.
 */
class PermissionForm extends Model
{
    use PermissionAttributeLabelsTrait;

    public $name;
    public $description;

    private $permission;

    public function __construct(Permission $permission = null, $config = [])
    {
        $this->permission = $permission;

        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->permission) {
            return;
        }

        $this->name         = $this->permission->name;
        $this->description = $this->permission->description;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'], 'required', 'message' => 'Введите название разрешения'],

            [['description'], 'string'],
            [['description'], 'required', 'message' => 'Введите описание'],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->permission) {
            return false;
        }

        return true;
    }

    public function getPermission()
    {
        if ($this->permission === null) {
            $this->permission = new Permission();
        }

        return $this->permission;
    }
}
