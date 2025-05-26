<?php declare(strict_types=1);

use app\modules\user\Module as UserModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $form yii\bootstrap\ActiveForm
// @var $model \common\models\LoginForm

$this->title = UserModule::t('common', 'SIGN_IN');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>",
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?php echo Yii::$app->params['name'] ?? UserModule::t('common', 'SIGN_IN_AUTHORIZATION'); ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo UserModule::t('common', 'SIGN_IN_WELCOME'); ?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?php echo $form
            ->field($model, 'email', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]); ?>

        <?php echo $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]); ?>

        <div class="row">
            <div class="col-xs-8">
                <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?php echo Html::submitButton(UserModule::t('common', 'SIGN_IN'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']); ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
