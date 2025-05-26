<?php declare(strict_types=1);

use yii\helpers\Html;

?>

<div class="form-group coords-picker" data-provider="<?php echo $mapProvider; ?>" data-zoom="<?php echo $zoom; ?>" data-options='<?php echo !empty($options) ? json_encode($options) : json_encode([]); ?>'>
    <div class="row">
        <div class="col-lg-<?php echo $mapColumnSize; ?>">
            <div class="coords-picker-map" style="width: 100%; height: <?php echo $mapHeight; ?>"></div>
        </div>

        <div class="col-lg-<?php echo $attributesColumnSize; ?>">
            <div class="form-group" <?php if (!$enableSearch) { ?>style="display: none;"<?php } ?>>
                <?php echo Html::hiddenInput('', $cityName, ['class' => 'coords-picker-city']); ?>

                <?php echo Html::button($buttonText, ['class' => 'btn bg-olive coords-picker-search-btn']); ?>
            </div>

            <?php foreach ($attributes as $attribute) { ?>

            <?php echo $form->field($model, $attribute)->textInput(['maxlength' => true, 'class' => "form-control coords-picker-{$attributesMap[$attribute]}"]); ?>

            <?php } ?>
        </div>
    </div>
</div>
