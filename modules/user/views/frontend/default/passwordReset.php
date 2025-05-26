<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $form yii\bootstrap\ActiveForm
// @var $model \app\modules\user\forms\frontend\PasswordResetForm

$this->title = Module::t('common', 'TITLE_PASSWORD_RESET');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$fieldOptions = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Password</b>Reset</a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg"><?php echo Module::t('common', 'TITLE_PASSWORD_RESET'); ?></p>

        <?php $form = ActiveForm::begin(['id' => 'password-reset-form']); ?>
        <?php echo $form->field($model, 'password', $fieldOptions)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]); ?>
        <div class="form-group">
            <?php echo Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'reset-button']); ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>
