<?php declare(strict_types=1);

use app\modules\settings\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// @var $this yii\web\View
// @var $model app\modules\setting\models\Setting
// @var $modelValue app\modules\setting\models\SettingValue
// @var $form yii\widgets\ActiveForm
?>

<div class="setting-form">

<?php $form = ActiveForm::begin([
    'id' => 'setting-form',
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>
    <?php echo Html::hiddenInput('save_and_edit', 0, [
        'data-edit-field' => true,
    ]); ?>

    <?php echo $form->field($model, 'type_id')->hiddenInput(['id' => 'setting-type'])->label(false); ?>

    <?php echo $form->field($model, 'is_multiple')->checkbox(); ?>

    <?php echo $form->field($model, 'title')->textInput(); ?>

    <?php echo $form->field($model, 'group_id')->dropDownList(ArrayHelper::map($groups, 'id', 'title'), [
        'prompt' => 'Укажите группу',
    ]); ?>

    <?php echo $form->field($model, 'key')->textInput(); ?>

    <?php echo $form->field($model, 'desc')->textarea(['rows' => 5]); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Module::t('common', 'BUTTON_CREATE'), ['class' => 'btn btn-success']); ?>
        <?php echo Html::button(Module::t('common', 'BUTTON_CREATE_AND_EDIT'), [
            'class' => 'btn btn-primary',
            'data-create-and-edit' => true,
        ]); ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
