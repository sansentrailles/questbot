<?php declare(strict_types=1);

use app\modules\seo\Module;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// @var $this yii\web\View
// @var $model app\modules\seo\models\Seo
// @var $form yii\widgets\ActiveForm
?>

<div class="seo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'ref_id')->hiddenInput()->label(false); ?>

    <?php echo $form->field($model, 'section')->hiddenInput(['maxlength' => true])->label(false); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'keywords')->textInput(['maxlength' => true]); ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

    <?php /*
    <?= $form->field($model, 'text')->widget(TinyMce::className(), [
        'options' => ['rows' => 20],
        'language' => Yii::$app->language,
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap hr preview pagebreak",
                "searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking",
                "save insertdatetime media contextmenu paste",
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist outdent indent | link media",
            'force_br_newlines' => false,
            'force_p_newlines' => true,
            'forced_root_block' => '',
        ],
        ]) ?>
*/ ?>
<?php ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if ($model->id) { ?>
        <?php $form = ActiveForm::begin([
            'action' => ['seo/delete', 'id' => $model->id, 'section' => $section, 'redirectUrl' => $redirectUrl],
            'method' => 'POST',
        ]); ?>
        <?php echo $form->field($model, 'id')->hiddenInput()->label(false); ?>
        <?php echo Html::submitButton('Удалить SEO', ['class' => 'btn btn-warning']); ?>
        <?php ActiveForm::end(); ?>
    <?php } ?>

</div>

