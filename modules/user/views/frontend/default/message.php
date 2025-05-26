<?php declare(strict_types=1);

use app\modules\user\Module;

// @var $this yii\web\View
// @var $form yii\bootstrap\ActiveForm
// @var $model \app\modules\user\forms\frontend\PasswordResetForm

$this->title = Module::t('common', 'TITLE_PASSWORD_RESET');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?php echo Yii::$app->name; ?></b>App</a>
    </div>

    <div class="login-box-body">

        <p class="login-box-msg"><?php echo $message; ?></p>

        <div class="row">
            <div class="col-lg-6"><a href="/"><?php echo Module::t('common', 'USER_GO_TO_MAIN'); ?></a></div>
            <div class="col-lg-6" style="text-align: right;"><a href="/login"><?php echo Module::t('common', 'USER_GO_TO_LOGIN'); ?></a></div>
        </div>
    </div>

</div>
