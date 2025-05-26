<div class="row value-item" data-index="<?php echo $index; ?>">
    <div class="col-md-11">
        <?php echo $form->field($valueModel, "[{$index}]value")->textArea(['rows' => 7])->label(false); ?>
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
