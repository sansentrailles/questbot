<?php

declare(strict_types=1);

namespace app\modules\user\forms\frontend;

use app\modules\user\models\User;
use app\modules\user\Module;
use yii\base\Model;

class ProfileUpdateForm extends Model
{
    public $firstname;
    public $lastname;
    public $phone;

    /**
     * @var User
     */
    private $_user;

    /**
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function init(): void
    {
        $this->firstname = $this->_user->firstname;
        $this->lastname = $this->_user->lastname;
        $this->phone = $this->_user->phone;
        parent::init();
    }

    public function rules()
    {
        return [
            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2, 'max' => 255],

            ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'required'],
            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'filter', 'filter' => '\app\helpers\PhoneHelper::clearPhone'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'firstname' => Module::t('common', 'USER_FIRSTNAME'),
            'lastname' => Module::t('common', 'USER_LASTNAME'),
            'phone' => Module::t('common', 'USER_PHONE'),
        ];
    }

    /**
     * @return bool
     */
    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->phone = $this->phone;
            return $user->save();
        }
        return false;
    }
}
