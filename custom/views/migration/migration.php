<?php declare(strict_types=1);
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 */
// @var $className string the new migration class name without namespace
/** @var string $namespace the new migration class namespace */
echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

namespace app\modules\MODULE_NAME_HERE\migrations;

use yii\db\Migration;

/**
 * Class <?php echo $className . "\n"; ?>
 */
class <?php echo $className; ?> extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "<?php echo $className; ?> cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "<?php echo $className; ?> cannot be reverted.\n";

        return false;
    }
    */
}
