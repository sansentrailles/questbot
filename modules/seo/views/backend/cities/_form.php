<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\seo\Module;
use dosamigos\tinymce\TinyMce;
use app\modules\seo\models\City;
use app\custom\widgets\backend\delete\Delete;

/* @var $this yii\web\View */
/* @var $model app\modules\seo\models\City */
/* @var $form yii\widgets\ActiveForm */

$formName = \yii\helpers\StringHelper::basename(get_class($model));

?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'is_visible')->checkbox() ?>

        <?php echo $form->field($model, 'is_default')->checkbox(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
        <h4>Параметры</h4>
        <?= Html::button('Добавить', ['class' => 'btn btn-primary', 'onclick' => 'addField("masks")']) ?>

    </div>

    <div id="masks-list">
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <b>Маска</b>
                </div>
                <div class="col-md-4">
                    <b>Форма</b>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </div>
        <?php if (is_array($model->masks)) { ?>
            <?php foreach ($model->masks as $mask) { ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <?= Html::input('text', $formName.'[masks_titles][]', $mask->title, ['class' => 'form-control']) ?>
                        </div>
                        <div class="col-md-3">
                            <?= Html::input('text', $formName.'[masks_forms][]', $mask->form, ['class' => 'form-control']) ?>
                        </div>
                        <div class="col-md-2">
                            <?= Html::button('Удалить', ['class' => 'btn btn-success', 'onclick' => 'removeField(this)']) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<div id="masks-etalon" style="display:none">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <?= Html::input('text', $formName.'[etalon-masks_titles][]', '', ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-3">
                <?= Html::input('text', $formName.'[etalon-masks_forms][]', '', ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::button('Удалить', ['class' => 'btn btn-success', 'onclick' => 'removeField(this)']) ?>
            </div>
        </div>
    </div>
</div>