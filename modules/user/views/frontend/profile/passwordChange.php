<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $model \app\modules\user\forms\frontend\PasswordChangeForm

$this->title = Module::t('common', 'TITLE_PASSWORD_CHANGE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-password-change">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]); ?>
        <?php echo $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]); ?>
        <?php echo $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]); ?>

        <div class="form-group">
            <?php echo Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-primary', 'name' => 'change-button']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
