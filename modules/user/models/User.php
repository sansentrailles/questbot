<?php

declare(strict_types=1);

namespace app\modules\user\models;

use app\custom\helpers\PhoneHelper;
use app\modules\user\forms\backend\UserForm as Form;
use app\modules\user\models\traits\UserAttributeLabelsTrait;
use app\modules\user\models\traits\UserIdentityTrait;
use app\modules\user\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $username
 * @property string $access_token
 * @property string $firstname
 * @property string $lastname
 * @property string $auth_key
 * @property string $email_confirm_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property int $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    use UserAttributeLabelsTrait;
    use UserIdentityTrait;

    public const STATUS_BLOCKED = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_WAIT = 2;

    public const STATE_SYSTEM = 1;
    public const STATE_NOT_SYSTEM = 0;

    private $_role = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function add(Form $form)
    {
        $model = new self();

        $model->firstname    = $form->firstname;
        $model->lastname     = $form->lastname;
        $model->phone        = $form->phone;
        $model->email        = $form->email;
        $model->status       = $form->status;
        $model->role         = $form->role;
        $model->is_system    = $form->is_system;
        $model->access_token = $form->access_token;

        if (!empty($form->new_password)) {
            $model->setPassword($form->new_password);
        }

        return $model;
    }

    public function edit(Form $form): void
    {
        $this->firstname    = $form->firstname;
        $this->lastname     = $form->lastname;
        $this->phone        = $form->phone;
        $this->email        = $form->email;
        $this->status       = $form->status;
        $this->role         = $form->role;
        $this->is_system    = $form->is_system;
        $this->access_token = $form->access_token;

        if (!empty($form->new_password)) {
            $this->setPassword($form->new_password);
        }
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => Module::t('common', 'USER_STATUS_BLOCKED'),
            self::STATUS_ACTIVE => Module::t('common', 'USER_STATUS_ACTIVE'),
            self::STATUS_WAIT => Module::t('common', 'USER_STATUS_WAIT'),
        ];
    }

    /**
     * @return string role name
     */
    public function getRole()
    {
        if ($this->_role) {
            return $this->_role;
        }

        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        $role = array_shift($roles);

        $this->_role = !empty($role) ? $role->name : '';

        return $this->_role;
    }

    /**
     * @param string role name
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->_role = $role;
    }

    public function getClearedPhone()
    {
        return PhoneHelper::skipCountryCode($this->phone);
    }

    public function setClearedPhone($phone): void
    {
        $this->phone = PhoneHelper::clearPhone($phone);
    }

    /**
     * @return string fullname
     */
    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        // $this->updateRole();
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Updates role.
     */
    protected function updateRole()
    {
        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole($this->role);

        if (empty($role)) {
            return false;
        }

        $authManager->revokeAll($this->id);

        return $authManager->assign($role, $this->id);
    }
}
