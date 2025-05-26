<?php declare(strict_types=1);

use app\custom\widgets\backend\arrayField\helpers\ErrorHelper;
use yii\helpers\Html;

?>

<div class="field-list" id="<?php echo $attribute; ?>-template" style="display:none">
    <div class="row">
        <?php foreach ($fields as $field => $fieldParams) { ?>
        <div class="col-lg-<?php echo $columnSize; ?>">
            <div class="form-group">
                <?php echo Html::input('text', '', '', ['class' => !empty($fieldParams['class']) ? $fieldParams['class'] : 'form-control', 'placeholder' => !empty($fieldParams['placeholder']) ? $fieldParams['placeholder'] : '', 'data-name' => $model->formName() . '[' . $attribute . '][0][' . $field . ']']); ?>
            </div>
        </div>
        <?php } ?>

        <div class="col-lg-<?php echo $buttonColumnSize; ?>">
            <div class="form-group">
                <?php echo Html::button(Yii::t('yii', 'Delete'), ['class' => 'btn btn-danger btn-remove-array-field', 'data-name' => $attribute]); ?>
            </div>
        </div>
    </div>
</div>

<?php if ($info) { ?>
<div class="callout callout-info">
    <h4><?php echo $info['header']; ?></h4>

    <p>
    <strong>
        <?php echo $info['text']; ?>
    </strong>
    </p>
</div>
<?php } ?>

<div class="form-group">
    <?php echo Html::button($buttonText, ['class' => 'btn btn-primary btn-add-array-field', 'data-name' => $attribute]); ?>
</div>

<div class="field-list" id="<?php echo $attribute; ?>-list">
<?php $counter = 0; ?>
<?php if ($model->{$attribute}) { ?>
    <?php foreach ($model->{$attribute} as $row) { ?>
        <div class="row">
            <?php foreach ($fields as $field => $fieldParams) { ?>
            <?php if (!isset($row[$field])) {
                continue;
            } ?>
            <div class="col-lg-<?php echo $columnSize; ?>">
                <?php $errors = ErrorHelper::getErrors($model, $attribute, $field, $counter); ?>
                <div class="form-group<?php if (!empty($errors)) { ?> has-error<?php } ?>">
                    <?php echo Html::input('text', $model->formName() . '[' . $attribute . '][' . $counter . '][' . $field . ']', $row[$field], ['class' => !empty($fieldParams['class']) ? $fieldParams['class'] : 'form-control', 'placeholder' => !empty($fieldParams['placeholder']) ? $fieldParams['placeholder'] : '']); ?>
                    <?php
                        foreach ($errors as $error) {
                            ?>
                        <div class="help-block"><?php echo $error; ?></div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <div class="col-lg-<?php echo $buttonColumnSize; ?>">
                <div class="form-group">
                    <?php echo Html::button(Yii::t('yii', 'Delete'), ['class' => 'btn btn-danger btn-remove-array-field', 'data-name' => $attribute]); ?>
                </div>
            </div>
        </div>
    <?php ++$counter; ?>
    <?php } ?>
<?php } ?>
</div>

<hr>
