<?php declare(strict_types=1);
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
// @var $className string the new migration class name without namespace
/** @var string $namespace the new migration class namespace */
// @var $table string the name table
// @var $fields array the fields

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yii\db\Migration;

/**
 * Handles the dropping of table `<?php echo $table; ?>`.
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
<?php echo $this->render('_dropTable', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
?>
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
<?php echo $this->render('_createTable', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
]);
?>
    }
}
