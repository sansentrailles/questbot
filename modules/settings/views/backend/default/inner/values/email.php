<?php declare(strict_types=1);

use app\modules\settings\models\Setting;

?>

<div class="row value-item" data-index="<?php echo $index; ?>">
    <div class="col-md-11">
        <?php echo $form->field($valueModel, "[{$index}]value")->textInput()->label(false); ?>
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
