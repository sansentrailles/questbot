<?php declare(strict_types=1);
/**
 * Creates a call for the method `yii\db\Migration::createTable()`.
 */
// @var $table string the name table
// @var $tableComment string the comment table
?>        $this->addCommentOnTable('<?php echo $table; ?>', '<?php echo $tableComment; ?>');
