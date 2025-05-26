<?php declare(strict_types=1);

use yii\helpers\ArrayHelper;

?>

<?php echo $form->field($model, 'is_multiple')->checkbox(); ?>

<?php echo $form->field($model, 'title')->textInput(); ?>

<?php echo $form->field($model, 'group_id')->dropDownList(ArrayHelper::map($groups, 'id', 'title'), [
    'prompt' => 'Укажите группу',
]); ?>

<?php echo $form->field($model, 'key')->textInput(); ?>

<?php echo $form->field($model, 'event_name')->textInput(); ?>

<?php echo $form->field($model, 'desc')->textarea(['rows' => 5]); ?>
