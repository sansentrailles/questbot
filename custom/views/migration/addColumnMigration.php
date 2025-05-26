<?php declare(strict_types=1);
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
// @var $className string the new migration class name without namespace
// @var $namespace string the new migration class namespace
// @var $table string the name table
// @var $fields array the fields

preg_match('/^add_(.+)_columns?_to_(.+)_table$/', $name, $matches);
$columns = $matches[1];

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yii\db\Migration;

/**
 * Handles adding <?php echo $columns; ?> to table `<?php echo $table; ?>`.
<?php echo $this->render('_foreignTables', [
    'foreignKeys' => $foreignKeys,
]); ?>
 */
class <?php echo $className; ?> extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
<?php echo $this->render('_addColumns', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
]);
?>
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
<?php echo $this->render('_dropColumns', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
]);
?>
    }
}
