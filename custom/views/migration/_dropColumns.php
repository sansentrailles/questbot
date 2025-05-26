<?php declare(strict_types=1);

echo $this->render('_dropForeignKeys', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);

foreach ($fields as $field) { ?>
        $this->dropColumn('<?php echo $table; ?>', '<?php echo $field['property']; ?>');
<?php }
