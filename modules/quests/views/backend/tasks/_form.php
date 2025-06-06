<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\quests\Module;
use app\modules\quests\models\Task;
use app\modules\quests\assets\MapAsset;
use app\custom\widgets\backend\delete\Delete;

MapAsset::register($this);
$cityName = '';

/** @var View $this */
/** @var Task $model */
/** @var ActiveForm $form */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'quest_id')->hiddenInput()->label(false); ?>
    
        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'place_show')->checkbox(); ?>

        <?php echo $form->field($model, 'question')->textarea(['rows' => 5]); ?>

        <?php echo $form->field($model, 'type')->dropDownList(Task::getTypes(), [
            'prompt' => 'Укажите тип ответа ',
        ]); ?>

        <?php echo $form->field($model, 'answer')->textInput(['maxlength' => true])->hint("<span class='text-green'>Только для типа ответа - ввод ответа</span>"); ?>

        <?php echo $form->field($model, 'place')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'address')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'message')->textarea(['rows' => 5]); ?>

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
                                    'url' => Url::to(['/admin/quests/tasks/delete-image', 'id' => $model->id]),
                                ]); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-6"></div>
            </div>
        </div>

        <div class="form-group coords-picker">
            <div class="row">
                <div class="col-lg-6">
                    <div class="coords-picker-map" id="map-picker" style="width: 100%; height: 400px"></div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group" >
                        <?php echo Html::hiddenInput('', $cityName, ['class' => 'coords-picker-city']); ?>

                        <?php echo Html::button(Module::t('common', 'ADDRESS_SEARCH'), ['class' => 'btn bg-olive coords-picker-search-btn']); ?>
                    </div>

                    <div class="form-group">
                        <?php echo Html::label(Module::t('common', 'ADDRESS_LINE'), 'search-by-address', ['class' => 'control-label']); ?>
                        <?php echo Html::textInput('', '', ['class' => 'form-control coords-picker-address']); ?>
                    </div>

                    <?php echo $form->field($model, 'latitude')->textInput(['maxlength' => true, 'class' => 'form-control coords-picker-latitude']); ?>

                    <?php echo $form->field($model, 'longitude')->textInput(['maxlength' => true, 'class' => 'form-control coords-picker-longitude']); ?>

                </div>
            </div>
        </div>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
