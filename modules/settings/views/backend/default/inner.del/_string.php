<?php declare(strict_types=1);

// use yii\base\DynamicModel;

$valueModel = $valueModels ? array_shift($valueModels) : null;
$index = 0;

?>

<h4>Значения</h4>
<div class="list-values">

    <div class="row">
        <div class="col-md-11">
            <?php echo $form->field($valueModel, "[{$index}]value")->textInput([
                'data-index' => $index,
            ])->label(false); ?>
        </div>
        <div class="col-md-1">
            <button title="Добавить значение" class="btn btn-primary">
                <span class="fa fa-plus"></span>
            </button>
        </div>
    </div>

    <?php foreach ($valueModels as $valueModel) {
        ++$index;
        ?>
        <div class="row">
            <div class="col-md-11">
                <?php echo $form->field($valueModel, "[{$index}]value")->textInput([
                    'data-index' => $index,
                ])->label(false); ?>
            </div>
            <div class="col-md-1">
                <button title=" значение" class="btn btn-primary">
                    <span class="fa fa-minus"></span>
                </button>
            </div>
        </div>
    <?php } ?>

</div>