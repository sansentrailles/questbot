<?php

declare(strict_types=1);

namespace app\modules\user\forms;

use app\modules\user\models\User;
use app\modules\user\Module;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => Module::t('common', 'USER_EMAIL'),
            'password' => Module::t('common', 'USER_PASSWORD'),
            'rememberMe' => Module::t('common', 'USER_REMEMBER_ME'),
        ];
    }

    /**
     * Validates the username and password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword(): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Module::t('common', 'ERROR_WRONG_USERNAME_OR_PASSWORD'));
            } elseif ($user && $user->status === User::STATUS_BLOCKED) {
                $this->addError('email', Module::t('common', 'ERROR_PROFILE_BLOCKED'));
            } elseif ($user && $user->status === User::STATUS_WAIT) {
                $this->addError('email', Module::t('common', 'ERROR_PROFILE_NOT_CONFIRMED'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]].
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
