<?php declare(strict_types=1);

use app\modules\settings\Module;
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
    <?php echo $form->field($model, 'type_id')->hiddenInput(['id' => 'setting-type'])->label(false); ?>

    <?php if (!$isDev) { ?>
        <?php echo $this->render('inner/edit', [
            'form' => $form,
            'model' => $model,
            'groups' => $groups,
        ]); ?>
    <?php } else { ?>
        <?php echo $this->render('inner/show', [
            'form' => $form,
            'model' => $model,
        ]); ?>
    <?php } ?>

    <?php echo $this->render('inner/values', [
        'form' => $form,
        'setting' => $setting,
        'valueModels' => $valueModels,
        'itemTemplate' => $itemTemplate,
    ]); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
