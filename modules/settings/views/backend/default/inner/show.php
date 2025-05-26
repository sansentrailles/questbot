<div class="form-group">
    <h3><?php echo $model->title; ?></h3>
</div>

<?php if ($model->desc) { ?>
    <div class="form-group">
        <h4><?php echo $model->desc; ?></h4>
    </div>
<?php } ?>


<?php echo $form->field($model, 'type_id')->hiddenInput()->label(false); ?>
<?php echo $form->field($model, 'is_multiple')->hiddenInput()->label(false); ?>
<?php echo $form->field($model, 'title')->hiddenInput()->label(false); ?>
<?php echo $form->field($model, 'group_id')->hiddenInput()->label(false); ?>
<?php echo $form->field($model, 'key')->hiddenInput()->label(false); ?>
<?php echo $form->field($model, 'desc')->hiddenInput()->label(false); ?>
