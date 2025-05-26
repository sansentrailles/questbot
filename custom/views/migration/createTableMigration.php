<?php declare(strict_types=1);
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
// @var $className string the new migration class name without namespace
/** @var string $namespace the new migration class namespace */
// @var $table string the name table
// @var $tableComment string the comment table
// @var $fields array the fields
// @var $foreignKeys array the foreign keys

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

namespace app\modules\MODULE_NAME\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `<?php echo $table; ?>`.
<?php echo $this->render('_foreignTables', [
    'foreignKeys' => $foreignKeys,
]); ?>
 */
class <?php echo $className; ?> extends Migration
{
    const TABLE_NAME = '<?php echo $table; ?>';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

<?php echo $this->render('_createTable', [
    'table' => $table,
    'fields' => $fields,
    'foreignKeys' => $foreignKeys,
]);
?>
<?php if (!empty($tableComment)) {
    echo $this->render('_addComments', [
        'table' => $table,
        'tableComment' => $tableComment,
    ]);
}
?>
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
<?php echo $this->render('_dropTable', [
    'table' => $table,
    'foreignKeys' => $foreignKeys,
]);
?>
    }
}
