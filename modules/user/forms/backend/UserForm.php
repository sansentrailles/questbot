<?php

declare(strict_types=1);

namespace app\modules\user\forms\backend;

use app\modules\user\models\traits\UserAttributeLabelsTrait;
use app\modules\user\models\User;
use yii\base\Model;

/**
 * UserForm is the model behind the user item form.
 */
class UserForm extends Model
{
    use UserAttributeLabelsTrait;

    public const SCENARIO_CREATE = 'user_create';
    public const SCENARIO_UPDATE = 'user_update';

    public $id;
    public $status;
    public $email;
    public $phone;
    public $firstname;
    public $lastname;
    public $is_system;
    public $access_token;

    public $new_password;
    public $new_password_repeat;

    public $role;

    private $user;

    public function __construct(User $user = null, $config = [])
    {
        $this->user = $user;

        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->user) {
            return;
        }

        $this->id           = $this->user->id;
        $this->status       = $this->user->status;
        $this->email        = $this->user->email;
        $this->phone        = $this->user->phone;
        $this->firstname    = $this->user->firstname;
        $this->lastname     = $this->user->lastname;
        $this->is_system    = $this->user->is_system;
        $this->access_token = $this->user->access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_system'], 'in', 'range' => [User::STATE_SYSTEM, User::STATE_NOT_SYSTEM]],
            [['access_token'], 'string', 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'filter' => function ($query): void {
                if ($this->id) {
                    $query->andWhere('id <> :id', [':id' => $this->id]);
                }
            }],
            ['email', 'string', 'max' => 255],

            ['firstname', 'string', 'max' => 255],
            ['lastname', 'string', 'max' => 255],
            ['phone', 'string'],
            // ['phone', 'required'],

            ['status', 'integer'],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(User::getStatusesArray())],

            ['role', 'string', 'max' => 64],

            [['new_password', 'new_password_repeat'], 'required', 'on' => self::SCENARIO_CREATE],
            ['new_password', 'string', 'min' => 6],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Пароли не совпадают'],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->user) {
            return false;
        }

        return true;
    }

    public function getUser()
    {
        if ($this->user === null) {
            $this->user = new User();
        }

        return $this->user;
    }

    public function getPrimaryKey()
    {
        if ($this->user) {
            return $this->user->primaryKey;
        }

        return null;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = [
            'firstname',
            'lastname',
            'email',
            'phone',
            'status',
            'role',
            'new_password',
            'new_password_repeat',
            'is_system',
            'access_token',
        ];

        $scenarios[self::SCENARIO_UPDATE] = [
            'firstname',
            'lastname',
            'email',
            'phone',
            'status',
            'role',
            'new_password',
            'new_password_repeat',
            'is_system',
            'access_token',
        ];
        return $scenarios;
    }
}
