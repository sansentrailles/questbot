<?php declare(strict_types=1);

// $valueModel = $valueModels ? array_shift($valueModels) :  null ;
$i = 0;

?>

<h4>Значение</h4>
<div class="list-values" data-setting-id="<?php echo $setting->id; ?>">
    <?php foreach ($valueModels as $index => $valueModel) {
        ++$i;
        ?>

        <?php echo $this->render($itemTemplate, [
            'isFirst' => $i === 1,
            'index' => $index,
            'form' => $form,
            'valueModel' => $valueModel,
            'setting' => $setting,
        ]);
        ?>
    <?php } ?>

</div>
