<?php declare(strict_types=1);

use app\modules\user\Module;

/** @var yii\web\View $this */
/** @var app\modules\user\models\User $user */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/password-reset', 'token' => $user->password_reset_token]);
?>

<?php echo Module::t('common', 'HELLO {username}', ['username' => $user->username]); ?>

<?php echo Module::t('common', 'FOLLOW_TO_RESET_PASSWORD'); ?>

<?php echo $resetLink; ?>
