<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// @var $this yii\web\View
// @var $model yii\rbac\Permission
// @var $form yii\widgets\ActiveForm

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->field($model, 'name')->textInput([
        'readonly' => $model->getIsNewRecord() === false,
    ]); ?>

    <?php echo $form->field($model, 'description')->textarea(); ?>

    <?php echo $form->field($model, 'permissions[]')->checkboxList(ArrayHelper::map($permissions, 'name', 'description'), [
        'multiple' => true,
        'size' => '15',
        'separator' => '<br>',
    ]); ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        );
?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
