<?php declare(strict_types=1);

use yii\helpers\Html;

?>

<div class="row image-widget" data-without-crop="<?php echo (bool)$options['withoutCrop']; ?>" data-resize-width="<?php echo $options['resizeWidth']; ?>" data-resize-height="<?php echo $options['resizeHeight']; ?>" data-crop-width="<?php echo $options['cropWidth']; ?>" data-crop-height="<?php echo $options['cropHeight']; ?>" <?php /* data-width="<?= $options['width']?>" data-height="<?= $options['height']?>" */ ?> data-action="<?php echo $action; ?>">
    <div class="form-group">
        <div class="col-lg-12 col-md-12 col-sm-12">

            <?php echo Html::activeFileInput($model, $widget->attribute, ['class' => 'file-uploader form-control']); ?>
            <?php // = Html::activeFileInput($model, 'imageThumbFile', ['class' => 'file-uploader1 form-control'])?>

            <?php // = Html::activeHiddenInput($model, $widget->thumb, ['class' => 'file-thumb-upload'])?>
            <?php // = Html::fileInput($model->{$widget->attribute}, '', ['class' => 'file-uploader form-control'])?>
            <?php // = Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']);?>
            <div class="help-block"></div>

            <div class="progress">
                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>

            <div class="result-image-container">
                <?php if ($model->{$widget->attribute}) { ?>
                    <img src="<?php echo $model->{$pathAttribute}; ?>" alt="">
                <?php } ?>
            </div>
            <div class="image-widget-manager">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="box box-solid image-widget-preloaded-image">
                        <div class="box-header with-border">
                            <i class="fa fa-file-picture-o"></i>
                            <h3 class="box-title"><?php echo Yii::t('imager', 'Uploaded Image'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="image-container"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-pencil"></i>
                            <h3 class="box-title"><?php echo Yii::t('imager', 'Information'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <button type="button" class="btn bg-orange btn-flat margin upload-image">
                                <span class="fa fa-download"></span>
                                Загрузить
                            </button>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-header with-border">
                            <i class="fa fa-info"></i>
                            <h3 class="box-title">Информация</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="quality-box">
                                        <td class="info-parameter ">
                                            <div class="">Качество: <span class="quality-label"></span></div>
                                        </td>
                                        <td class="info-value">
                                            <input type="range" class="quality-field" min="0" max="100" value="60">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="info-parameter">Название файла</td>
                                        <td class="info-value file-info-name"></td>
                                    </tr>

                                    <tr>
                                        <td class="info-parameter">MIME-type</td>
                                        <td class="info-value file-info-type"></td>
                                    </tr>

                                    <tr>
                                        <td class="info-parameter">Размер</td>
                                        <td class="info-value file-info-size"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

