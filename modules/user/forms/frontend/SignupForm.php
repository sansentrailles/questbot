<?php

declare(strict_types=1);

namespace app\modules\user\forms\frontend;

use app\modules\user\models\User;
use app\modules\user\Module;
use Yii;
use yii\base\Model;

/**
 * Signup form.
 */
class SignupForm extends Model
{
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $password;
    public $verifyCode;

    private $_defaultRole;

    /**
     * @param string $defaultRole
     * @param array $config
     */
    public function __construct($defaultRole, $config = [])
    {
        $this->_defaultRole = $defaultRole;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2, 'max' => 255],

            ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Module::t('common', 'ERROR_EMAIL_EXISTS')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['phone', 'required'],
            // ['phone', 'filter', 'filter' => 'trim'],
            // ['phone', 'filter', 'filter' => '\app\helpers\PhoneHelper::clearPhone'],

            ['verifyCode', 'captcha', 'captchaAction' => '/user/default/captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('common', 'USER_USERNAME'),
            'firstname' => Module::t('common', 'USER_FIRSTNAME'),
            'lastname' => Module::t('common', 'USER_LASTNAME'),
            'email' => Module::t('common', 'USER_EMAIL'),
            'phone' => Module::t('common', 'USER_PHONE'),
            'password' => Module::t('common', 'USER_PASSWORD'),
            'verifyCode' => Module::t('common', 'USER_VERIFY_CODE'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->email = $this->email;
            $user->clearedPhone = $this->phone;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT;
            $user->role = $this->_defaultRole;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            if ($user->save()) {
                Yii::$app->mailer->compose(['text' => Yii::$app->controller->module->mailTemplatesPath . '/emailConfirm'], ['user' => $user])
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject(Module::t('common', 'USER_EMAIL_CONFIRMATION_FOR') . ' ' . Yii::$app->name)
                    ->send();

                return $user;
            }
        }

        return null;
    }
}
