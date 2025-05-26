<?php declare(strict_types=1);

use yii\base\DynamicModel;
use yii\helpers\Html;

$value = $values ? array_shift($values) : '';
// $model = DynamicModel::validateData(array('value'), [['value', 'string', 'max' => 10, 'min' => 3]]);
// $model = DynamicModel::validateData(['value'], [['value', 'email', 'message' => 'Неправильный формат Email']]);
// $model = DynamicModel::validateData(['value'], [['value', 'each', 'rule' => ['email'], 'message' => 'Неправильный формат Email']]);

?>

<div class="form-group value-input<?php if ($is_multiple) { ?> multiple<?php } ?>">
    <div class="input-group">

        <?php // = $form->field($model, 'value')->textInput()->label(false);?>
        <?php // = $form->field($model, 'value[]')->textInput()->label(false);?>

        <?php echo Html::textInput('values[]', $value, ['class' => 'form-control']); ?>
        <span class="input-group-btn">
            <button type="button" class="btn btn-success" data-add-item data-id="values" data-name='values[]' title="Добавить значение">
                <span class="fa fa-plus"></span>
            </button>
        </span>
    </div>
</div>

<div id="values-list" class="values-container<?php if ($is_multiple) { ?> multiple<?php } ?>">
    <?php foreach ($values as $index => $value) { ?>
        <div class="form-group value-native">

            <?php echo $form->field($model, "[{$index}]value")->label($value); ?>

            <div class="input-group">

                <?php echo Html::textInput('values[]', $value, [
                    'class' => 'form-control',
                ]); ?>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-danger" data-remove-item title="Удалить значение">
                        <span class="fa fa-minus"></span>
                    </button>
                </span>
            </div>
        </div>
    <?php } ?>
</div>

<div id="values-template" class="hidden">
    <div class="form-group">
        <div class="input-group dynamic">
            <?php echo Html::textInput('', '', [
                'class' => 'form-control input-field',
            ]); ?>
            <span class="input-group-btn">
                <button type="button" class="btn btn-danger" data-remove-item title="Удалить значение"><span class="fa fa-minus"></span></button>
            </span>
        </div>
    </div>
</div>