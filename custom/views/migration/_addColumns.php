<?php declare(strict_types=1);
foreach ($fields as $field) { ?>
        $this->addColumn('<?php echo $table;
    ?>', '<?php echo $field['property'];
    ?>', $this-><?php echo $field['decorators'];
    ?>);
<?php }

echo $this->render('_addForeignKeys', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
