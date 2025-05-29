<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\quests\Module;
use app\modules\quests\models\Answer;

/** @var View $this */
/** @var Answer $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'task_id')->hiddenInput()->label(false); ?>
    
        <?php echo $form->field($model, 'is_right')->checkbox(); ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true])->hint("<span class='text-green'>Только для типа ответа - ввод ответа</span>"); ?>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
