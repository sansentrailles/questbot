<?php declare(strict_types=1);

use app\modules\settings\models\Setting;

$key = Yii::$app->params['rf_akey'];

?>

<div class="row value-item" data-index="<?php echo $index; ?>">
    <div class="col-md-11">
        <?php echo $form->field($valueModel, "[{$index}]value", [
            'template'=> '<div class="input-group">{input}<span class="input-group-addon"><a data-fancybox data-type="iframe" data-src="/js/plugins/responsive_filemanager/filemanager/dialog.php?type=0&lang=ru&relative_url=1&akey=' . $key . '&field_id=settingselectedfilevalueform-' . $index . '-value" class="btn btn-success btn-flat"><span class="fa fa-folder-open"></span></a></span></div>{error}'])->textInput()->label(false); ?>
    </div>
    <?php if ($setting->is_multiple === Setting::STATE_MULTIPLE) { ?>
        <div class="col-md-1">
            <?php if ($isFirst) { ?>
                <button title="Добавить значение" data-add-field-value class="btn btn-primary">
                    <span class="fa fa-plus"></span>
                </button>
            <?php } else { ?>
                <button title="Удалить значение" data-remove-field-value class="btn btn-warning">
                    <span class="fa fa-minus"></span>
                </button>
            <?php } ?>
        </div>
    <?php } ?>
</div>
