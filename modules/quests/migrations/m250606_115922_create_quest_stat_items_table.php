<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quest_stat_items}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quest_stats}}`
 * - `{{%quest_tasks}}`
 */
class m250606_115922_create_quest_stat_items_table extends Migration
{
    const TABLE_NAME = '{{%quest_stat_items}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'stat_id' => $this->integer(),
            'task_id' => $this->integer(),
            'question' => $this->text(),
            'task_answer' => $this->text(),
            'user_answer' => $this->text(),
            'is_correct' => $this->boolean()->defaultValue(false),
            'hint_used' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `stat_id`
        $this->createIndex(
            '{{%idx-quest_stat_items-stat_id}}',
            '{{%quest_stat_items}}',
            'stat_id'
        );

        // add foreign key for table `{{%quest_stats}}`
        $this->addForeignKey(
            '{{%fk-quest_stat_items-stat_id}}',
            '{{%quest_stat_items}}',
            'stat_id',
            '{{%quest_stats}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-quest_stat_items-task_id}}',
            '{{%quest_stat_items}}',
            'task_id'
        );

        // add foreign key for table `{{%quest_tasks}}`
        $this->addForeignKey(
            '{{%fk-quest_stat_items-task_id}}',
            '{{%quest_stat_items}}',
            'task_id',
            '{{%quest_tasks}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%quest_stats}}`
        $this->dropForeignKey(
            '{{%fk-quest_stat_items-stat_id}}',
            '{{%quest_stat_items}}'
        );

        // drops index for column `stat_id`
        $this->dropIndex(
            '{{%idx-quest_stat_items-stat_id}}',
            '{{%quest_stat_items}}'
        );

        // drops foreign key for table `{{%quest_tasks}}`
        $this->dropForeignKey(
            '{{%fk-quest_stat_items-task_id}}',
            '{{%quest_stat_items}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-quest_stat_items-task_id}}',
            '{{%quest_stat_items}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
