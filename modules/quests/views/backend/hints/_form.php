<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\quests\Module;
use app\modules\quests\models\Hint;
use app\custom\widgets\backend\delete\Delete;

/** @var View $this */
/** @var Hint $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'task_id')->hiddenInput()->label(false); ?>
    
        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'text')->textarea(['rows' => 5]); ?>

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $form->field($model, 'imageFile')->fileInput(); ?>

                    <?php if ($model->image) { ?>
                        <div class="row" data-removable>
                            <div class="col-md-6">
                                <img src="<?php echo $model->imagePath; ?>" alt="" class='img-responsive'>
                            </div>
                            <div class="col-md-6">
                                <?php echo Delete::widget([
                                    'url' => Url::to(['/admin/quests/hints/delete-image', 'id' => $model->id]),
                                ]); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-6"></div>
            </div>
        </div>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
