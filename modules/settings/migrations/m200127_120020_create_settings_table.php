<?php

declare(strict_types=1);

namespace app\modules\settings\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 * Has foreign keys to the tables:.
 *
 * - `setting_groups`
 */
class m200127_120020_create_settings_table extends Migration
{
    public const TABLE_NAME = 'settings';

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
            'title' => $this->string(),
            'key' => $this->string(),
            'group_id' => $this->integer()->notNull(),
            'desc' => $this->text(),
            'type_id' => $this->integer()->notNull(),
            'is_multiple' => $this->boolean()->defaultValue(0),
            // 'is_multilang' => $this->boolean()->defaultValue(0),
            // 'is_required' => $this->boolean()->defaultValue(0),
        ], $tableOptions);

        // creates index for column `group_id`
        $this->createIndex(
            'idx-settings-group_id',
            'settings',
            'group_id'
        );

        // add foreign key for table `setting_groups`
        $this->addForeignKey(
            'fk-settings-group_id',
            'settings',
            'group_id',
            'setting_groups',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // drops foreign key for table `setting_groups`
        $this->dropForeignKey(
            'fk-settings-group_id',
            'settings'
        );

        // drops index for column `group_id`
        $this->dropIndex(
            'idx-settings-group_id',
            'settings'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
