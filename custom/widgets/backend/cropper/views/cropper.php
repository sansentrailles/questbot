<?php declare(strict_types=1);
use yii\helpers\Html;

?>

<div class="container-cropper">
    <div class="form-group">
        <div class="cropper-options">
            <?php echo Html::hiddenInput('action', $action, ['class' => 'action']); ?>
            <?php echo Html::hiddenInput('withoutCrop', $options['withoutCrop'], ['class' => 'withoutCrop']); ?>
            <?php echo Html::hiddenInput('cropWidth', $options['cropWidth'], ['class' => 'cropWidth']); ?>
            <?php echo Html::hiddenInput('cropHeight', $options['cropHeight'], ['class' => 'cropHeight']); ?>

            <?php echo Html::hiddenInput('resizeWidth', $options['resizeWidth'], ['class' => 'resizeWidth']); ?>
            <?php echo Html::hiddenInput('resizeHeight', $options['resizeHeight'], ['class' => 'resizeHeight']); ?>
        </div>

        <?php echo Html::activeFileInput($model, $widget->attribute, ['class' => 'file-uploader form-control']); ?>
        <?php echo Html::activeHiddenInput($model, $widget->attribute, ['class' => 'prev-cropped']); ?>
        <?php if ($widget->thumb) { ?>
            <?php echo Html::activeHiddenInput($model, $widget->thumb, ['class' => 'file-thumb-upload']); ?>
        <?php } ?>

        <div class="help-block"></div>

        <div class="row image-widget-manager">
            <div class="form-group">
                <div class="col-md-6">
                    <h3>Изображение</h3>
                    <div class="original-image-container"></div>
                    <button type="button" class="btn bg-orange btn-flat upload-image">
                        <span class="fa fa-download"></span>
                        Загрузить
                    </button>

                </div>

                <div class="col-md-6">
                    <h3>Обработанное изображение</h3>
                    <div class="result-image-container"></div>
                </div>
            </div>

        </div>
    </div>
</div>