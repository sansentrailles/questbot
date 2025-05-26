<?php declare(strict_types=1);

use app\modules\user\models\backend\User;
use app\modules\user\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

// @var $this yii\web\View
// @var $model \app\modules\user\models\backend\User
// @var $form yii\widgets\ActiveForm
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'clearedPhone')->widget(MaskedInput::className(), [
        'mask' => '+7-(999)-999-9999',
    ]); ?>

    <?php echo $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'status')->dropDownList(User::getStatusesArray()); ?>

    <?php echo $form->field($model, 'role')->dropDownList(
        ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
        ['options' => !empty($model->role) ?
            [
                $model->role => ['Selected'=>'selected'],
            ] :
            [
                Yii::$app->controller->module->defaultRole => ['Selected'=>'selected'],
            ],
        ]
    ); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_SAVE'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name' => 'submit-button',
        ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
