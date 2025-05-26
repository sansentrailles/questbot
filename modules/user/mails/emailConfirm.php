<?php declare(strict_types=1);

use app\modules\user\Module;

/** @var yii\web\View $this */
/** @var app\modules\user\models\User $user */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>

<?php echo Module::t('common', 'HELLO {username}', ['username' => $user->username]); ?>

<?php echo Module::t('common', 'FOLLOW_TO_CONFIRM_EMAIL'); ?>

<?php echo $confirmLink; ?>

<?php echo Module::t('common', 'IGNORE_IF_DO_NOT_REGISTER'); ?>
