<?php declare(strict_types=1);

use app\custom\widgets\backend\delete\Delete;
use app\modules\quests\models\Quest;
use app\modules\quests\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var Quest $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'desc')->textarea(['rows' => 8]); ?>

        <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'limit')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'date')->textInput(['maxlength' => true]); ?>

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
                                    'url' => Url::to(['/admin/quests/quests/delete-image', 'id' => $model->id]),
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
