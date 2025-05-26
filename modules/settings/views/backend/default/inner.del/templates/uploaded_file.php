<?php declare(strict_types=1);

use app\modules\settings\files\SettingFile;
use yii\helpers\Html;

?>

<div class="row value-item" data-index="<?php echo $index; ?>">
    <div class="col-md-11">
        <?php echo $form->field($valueModel, "[{$index}]valueFile")->fileInput()->label(false); ?>

        <?php if ($valueModel->value) { ?>
            <div class="row">
                <div class="col-md-2">
                    <p><?php echo Html::a('Файл', SettingFile::getPath($valueModel->value), ['target' => '_blank']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php /*
    <div class="col-md-1">
        <?php if($index == 0) { ?>
            <button title="Добавить значение" data-add-field-value class="btn btn-primary">
                <span class="fa fa-plus"></span>
            </button>
        <?php } else { ?>
            <button title="Удалить значение" data-remove-field-value class="btn btn-warning">
                <span class="fa fa-minus"></span>
            </button>
        <?php } ?>
    </div>
    */ ?>
</div>
