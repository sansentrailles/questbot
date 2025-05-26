<?php declare(strict_types=1);

/**
 * Creates a call for the method `yii\db\Migration::createTable()`.
 */
// @var $table string the name table
// @var $fields array the fields
// @var $foreignKeys array the foreign keys

?>        $this->createTable(self::TABLE_NAME, [
<?php foreach ($fields as $field) {
    if (empty($field['decorators'])) { ?>
            '<?php echo $field['property']; ?>',
<?php } else { ?>
            <?php echo "'{$field['property']}' => \$this->{$field['decorators']}"; ?>,
<?php }
} ?>
        ], $tableOptions);
<?php echo $this->render('_addForeignKeys', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
