<?php declare(strict_types=1);

$valueModel = $valueModels ? array_shift($valueModels) : null;
$index = 0;

?>

<h4>Значения</h4>
<div class="list-values">

    <div class="row value-item" data-index="<?php echo $index; ?>">
        <div class="col-md-11">
            <?php echo $form->field($valueModel, '[0]value')->textInput(
                // [
                //     'data-index' => $index,
                // ]
            )->label(false); ?>
        </div>
        <div class="col-md-1">
            <button title="Добавить значение" data-add-field-value class="btn btn-primary">
                <span class="fa fa-plus"></span>
            </button>
        </div>
    </div>

    <?php foreach ($valueModels as $valueModel) {
        ++$index;
        ?>
        <div class="row value-item" data-index="<?php echo $index; ?>">
            <div class="col-md-11">
                <?php echo $form->field($valueModel, "[{$index}]value")->textInput(
                    // [
                    //     'data-index' => $index,
                    // ]
                )->label(false); ?>
            </div>
            <div class="col-md-1">
                <button title="Удалить значение" class="btn btn-warning">
                    <span class="fa fa-minus"></span>
                </button>
            </div>
        </div>
    <?php } ?>

</div>

<div class="field-template hidden">
    <div class="row value-item" data-index="{{index}}">
        <div class="col-md-11">
            <div class="form-group field-settingemailvalueform-{{index}}-value">
                <input type="text" id="settingemailvalueform-{{index}}-value" class="form-control input-item" data-name="SettingEmailValueForm[{{index}}][value]">
                <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-1">
            <button title="Удалить значение" class="btn btn-warning">
            <span class="fa fa-minus"></span>
            </button>
        </div>
    </div>
</div>