<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

// @var $this yii\web\View
// @var $model \app\modules\user\forms\frontend\ProfileUpdateForm

$this->title = Module::t('common', 'TITLE_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '+7-(999)-999-9999',
        ]); ?>

        <div class="form-group">
            <?php echo Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-primary', 'name' => 'update-button']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
