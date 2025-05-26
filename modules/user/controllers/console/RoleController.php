<?php

declare(strict_types=1);

namespace app\modules\user\controllers\console;

use app\modules\user\models\User;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;

/**
 * Interactive console roles manager.
 */
class RoleController extends Controller
{
    /**
     * Adds role to user.
     */
    public function actionList(): void
    {
        array_map(function ($description): void {
            $this->stdout($description . PHP_EOL);
        }, ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
    }

    /**
     * Adds role to user.
     */
    public function actionAssign(): void
    {
        $this->sayHello('Please answer the next questions to assign a role to a user:');
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $roleName = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole($roleName);
        $authManager->assign($role, $user->id);
        $this->stdout('Done!' . PHP_EOL);
    }

    /**
     * Removes the role from the user.
     */
    public function actionRevoke(): void
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $roleName = $this->select(
            'Role:',
            ArrayHelper::merge(
                ['all' => 'All Roles'],
                ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user->id), 'name', 'description')
            )
        );
        $authManager = Yii::$app->getAuthManager();
        if ($roleName === 'all') {
            $authManager->revokeAll($user->id);
        } else {
            $role = $authManager->getRole($roleName);
            $authManager->revoke($role, $user->id);
        }
        $this->stdout('Done!' . PHP_EOL);
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
        if (!$model = User::findOne(['email' => $email])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
}
