<?php declare(strict_types=1);

$valueModel = $valueModels ? array_shift($valueModels) : null;
$index = 0;

?>

<h4>Значения</h4>
<div class="list-values">

    <?php echo $this->render($itemTemplate, [
        'index' => $index,
        'form' => $form,
        'valueModel' => $valueModel,
    ]);
?>

    <?php foreach ($valueModels as $valueModel) {
        ++$index;
        ?>
        <?php echo $this->render($itemTemplate, [
            'index' => $index,
            'form' => $form,
            'valueModel' => $valueModel,
        ]);
        ?>
    <?php } ?>

</div>