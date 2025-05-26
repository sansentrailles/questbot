<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

// @var $this yii\web\View
// @var $form yii\bootstrap\ActiveForm
// @var $model \app\modules\user\forms\frontend\SignupForm

$this->title = Module::t('common', 'TITLE_SIGNUP');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>",
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>",
];

$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
];

$fieldOptions4 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-phone form-control-feedback'></span>",
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Sign</b>UP</a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg"><?php echo Module::t('common', 'SIGN_UP_WELCOME'); ?></p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?php echo $form->field($model, 'firstname', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('firstname')]); ?>

            <?php echo $form->field($model, 'lastname', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('lastname')]); ?>

            <?php echo $form->field($model, 'email', $fieldOptions2)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('email')]); ?>

            <?php echo $form->field($model, 'phone', $fieldOptions4)
                ->label(false)
                ->widget(MaskedInput::className(), [
                    'mask' => '+7-(999)-999-9999',
                ]); ?>

            <?php echo $form->field($model, 'password', $fieldOptions3)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]); ?>

            <?php echo $form->field($model, 'verifyCode')
                ->label(false)
                ->widget(Captcha::className(), [
                    'captchaAction' => '/user/default/captcha',
                    'template' => '<div class="row"><div class="col-lg-8">{image}</div><div class="col-lg-4">{input}</div></div>',
                ]); ?>

            <div class="form-group">
                <?php echo Html::submitButton(Module::t('common', 'USER_BUTTON_SIGNUP'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'signup-button']); ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
