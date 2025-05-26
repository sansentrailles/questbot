<?php declare(strict_types=1);

use dosamigos\tinymce\TinyMce;

?>

<div class="row value-item" data-index="<?php echo $index; ?>">
    <div class="col-md-11">
        <?php echo $form->field($valueModel, "[{$index}]value")->widget(TinyMce::class, [
            'options' => ['rows' => 7],
            'language' => Yii::$app->language,
            'clientOptions' => [
                'plugins' => [
                    'advlist autolink lists link charmap hr preview pagebreak anchor textcolor colorpicker',
                    'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                    'save insertdatetime media contextmenu paste image',
                ],
                'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link anchor | blockquote | forecolor backcolor',
                'force_br_newlines' => true,
                'force_p_newlines' => false,
                'forced_root_block' => '',
                'relative_urls' => false,
            ],
        ])->label(false); ?>
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
