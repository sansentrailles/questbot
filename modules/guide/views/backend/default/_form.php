<?php declare(strict_types=1);

use app\modules\guide\Module;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// @var $this yii\web\View
// @var $model app\modules\guide\models\GuideChapter
// @var $form yii\widgets\ActiveForm
?>

<div class="form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'is_visible')->checkbox(); ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>


        <?php echo $form->field($model, 'text')->widget(TinyMce::class, [
            'options' => ['rows' => 10],
            'language' => Yii::$app->language,
            'clientOptions' => [
                'plugins' => [
                    'advlist autolink lists link charmap hr preview pagebreak anchor textcolor colorpicker',
                    'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                    'save insertdatetime media contextmenu paste image',
                ],
                'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link anchor image media | blockquote | forecolor backcolor',
                'force_br_newlines' => true,
                'force_p_newlines' => false,
                'forced_root_block' => '',
                'external_filemanager_path' => '/js/plugins/responsivefilemanager/filemanager/',
                'filemanager_title' => 'Responsive Filemanager',
                'filemanager_access_key' => Yii::$app->params['rf_akey'],
                'external_plugins' => [
                    // Иконка/кнопка загрузки файла в диалоге вставки изображения.
                    'filemanager' => '/js/plugins/responsivefilemanager/filemanager/plugin.min.js',
                    // Иконка/кнопка загрузки файла в панеле иснструментов.
                    'responsivefilemanager' => '/js/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
                ],
                'relative_urls' => false,
            ],
        ]); ?>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Module::t('common', 'BUTTON_CREATE') : Module::t('common', 'BUTTON_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
