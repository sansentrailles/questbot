<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quest_task_answers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quest_tasks}}`
 */
class m250529_112036_create_quest_task_answers_table extends Migration
{
    const TABLE_NAME = '{{%quest_task_answers}}';
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
            'title' => $this->string(),
            'is_right' => $this->boolean()->defaultValue(false),
            'ord' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-quest_task_answers-task_id}}',
            '{{%quest_task_answers}}',
            'task_id'
        );

        // add foreign key for table `{{%quest_tasks}}`
        $this->addForeignKey(
            '{{%fk-quest_task_answers-task_id}}',
            '{{%quest_task_answers}}',
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
            '{{%fk-quest_task_answers-task_id}}',
            '{{%quest_task_answers}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-quest_task_answers-task_id}}',
            '{{%quest_task_answers}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
