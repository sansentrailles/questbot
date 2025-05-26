<?php

declare(strict_types=1);

namespace app\modules\user\controllers\console;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;

/**
 * Interactive console user manager.
 */
class UserController extends Controller
{
    public const DEFAULT_ADMIN_ROLE = 'admin';

    /**
     * Creates new user.
     */
    public function actionCreate(): void
    {
        $this->sayHello('Please answer the next questions to create a new user:');
        $user = new User();
        $this->readValue($user, 'email');
        $this->readValue($user, 'firstname');
        $this->readValue($user, 'lastname');
        $user->setPassword($this->prompt('Password:', [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => 'More than 6 symbols',
        ]));
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        $this->log($user->save(false));
    }

    public function actionCreateAdmin($email, $password): void
    {
        $user = User::findOne(['email' => $email]);
        if ($user) {
            $this->stdout('Admin user already exists.' . PHP_EOL, Console::FG_GREEN, Console::BOLD);
            return;
        }
        $user = new User();
        $user->email = $email;
        $user->firstname = 'admin';
        $user->lastname = 'admin';
        $user->access_token = 'kO%aYLa===-';
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        $user->save(false);
        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole(self::DEFAULT_ADMIN_ROLE);
        $authManager->assign($role, $user->id);
        $this->stdout('Admin user is created!' . PHP_EOL, Console::FG_GREEN, Console::BOLD);
    }

    /**
     * Changes the updated_at field to the current timestamp of a user with a specified email.
     * For testing purposes only.
     * @param mixed $email
     */
    public function actionTouchUser($email): void
    {
        $user = User::findOne(['email' => $email]);
        if (!$user) {
            $this->stdout('User with the specified email doesn\'t exist.' . PHP_EOL, Console::FG_GREEN, Console::BOLD);
            return;
        }
        $user->updated_at = time();
        $user->save(false);
        $this->stdout('The user has been updated!' . PHP_EOL, Console::FG_GREEN, Console::BOLD);
    }

    /**
     * Removes user by email.
     */
    public function actionDelete(): void
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $this->log($user->delete());
    }

    /**
     * Activates user.
     */
    public function actionActivate(): void
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        $this->log($user->save(false));
    }

    /**
     * Blocks user.
     */
    public function actionBlock(): void
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $user->status = User::STATUS_BLOCKED;
        $this->log($user->save(false));
    }

    /**
     * Changes user password.
     */
    public function actionChangePassword(): void
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $user->setPassword($this->prompt('New password:', [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => 'More than 6 symbols',
        ]));
        $this->log($user->save(false));
    }

    /**
     * greeting message.
     * @param mixed $message
     */
    private function sayHello($message): void
    {
        $this->stdout(PHP_EOL . $message . PHP_EOL);
    }

    /**
     * @param string $email
     * @return User the loaded model
     * @throws \yii\console\Exception
     */
    private function findModel($email)
    {
        if (!$user = User::findOne(['email' => $email])) {
            throw new Exception('User not found');
        }
        return $user;
    }

    /**
     * @param Model $user
     * @param string $attribute
     */
    private function readValue($user, $attribute): void
    {
        $user->{$attribute} = $this->prompt(mb_convert_case($attribute, MB_CASE_TITLE, 'utf-8') . ':', [
            'validator' => static function ($input, &$error) use ($user, $attribute) {
                $user->{$attribute} = $input;
                if ($user->validate([$attribute])) {
                    return true;
                }
                $error = implode(',', $user->getErrors($attribute));
                return false;
            },
        ]);
    }

    /**
     * @param bool $success
     */
    private function log($success): void
    {
        if ($success) {
            $this->stdout('Success!', Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr('Error!', Console::FG_RED, Console::BOLD);
        }
        $this->stdout(PHP_EOL);
    }
}
