<?php declare(strict_types=1);

use app\modules\settings\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// @var $this yii\web\View
// @var $model app\modules\setting\models\SettingGroup
// @var $form yii\widgets\ActiveForm
?>

<div class="settingform">

<?php $form = ActiveForm::begin([
    'id' => 'setting-form',
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>
    <?php echo $form->field($model, 'title')->textInput(); ?>

    <?php echo $form->field($model, 'name')->textInput([
        // 'readonly' => !$model->isNewRecord,
    ]); ?>

    <?php echo $form->field($model, 'desc')->textarea(['rows' => 5]); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
