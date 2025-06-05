<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quest_task_hints}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quest_tasks}}`
 */
class m250605_072101_create_quest_task_hints_table extends Migration
{
    const TABLE_NAME = '{{%quest_task_hints}}';
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
            'task_id' => $this->integer(),
            'image' => $this->string(),
            'text' => $this->text(),
            'is_visible' => $this->boolean()->defaultValue(false),
            'ord' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-quest_task_hints-task_id}}',
            '{{%quest_task_hints}}',
            'task_id'
        );

        // add foreign key for table `{{%quest_tasks}}`
        $this->addForeignKey(
            '{{%fk-quest_task_hints-task_id}}',
            '{{%quest_task_hints}}',
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
        // drops foreign key for table `{{%quest_tasks}}`
        $this->dropForeignKey(
            '{{%fk-quest_task_hints-task_id}}',
            '{{%quest_task_hints}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-quest_task_hints-task_id}}',
            '{{%quest_task_hints}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
