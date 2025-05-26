<?php

declare(strict_types=1);

namespace app\modules\settings\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `setting_value`.
 * Has foreign keys to the tables:.
 *
 * - `setting`
 */
class _m180717_085341_create_setting_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('setting_value', [
            'id' => $this->primaryKey(),
            'setting_id' => $this->integer()->notNull(),
            'value' => $this->text(),
        ], $tableOptions);

        // creates index for column `setting_id`
        $this->createIndex(
            'idx-setting_value-setting_id',
            'setting_value',
            'setting_id'
        );

        // add foreign key for table `setting`
        $this->addForeignKey(
            'fk-setting_value-setting_id',
            'setting_value',
            'setting_id',
            'setting',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // drops foreign key for table `setting`
        $this->dropForeignKey(
            'fk-setting_value-setting_id',
            'setting_value'
        );

        // drops index for column `setting_id`
        $this->dropIndex(
            'idx-setting_value-setting_id',
            'setting_value'
        );

        $this->dropTable('setting_value');
    }
}
