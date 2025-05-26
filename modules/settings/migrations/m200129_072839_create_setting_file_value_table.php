<?php

declare(strict_types=1);

namespace app\modules\settings\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `setting_file_value`.
 * Has foreign keys to the tables:.
 *
 * - `settings`
 */
class m200129_072839_create_setting_file_value_table extends Migration
{
    public const TABLE_NAME = 'setting_file_value';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'setting_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ], $tableOptions);

        // creates index for column `setting_id`
        $this->createIndex(
            'idx-setting_file_value-setting_id',
            'setting_file_value',
            'setting_id'
        );

        // add foreign key for table `settings`
        $this->addForeignKey(
            'fk-setting_file_value-setting_id',
            'setting_file_value',
            'setting_id',
            'settings',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // drops foreign key for table `settings`
        $this->dropForeignKey(
            'fk-setting_file_value-setting_id',
            'setting_file_value'
        );

        // drops index for column `setting_id`
        $this->dropIndex(
            'idx-setting_file_value-setting_id',
            'setting_file_value'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
