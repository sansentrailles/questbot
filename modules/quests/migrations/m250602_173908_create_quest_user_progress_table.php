<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quest_user_progress}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quests}}`
 * - `{{%quest_tasks}}`
 */
class m250602_173908_create_quest_user_progress_table extends Migration
{
    const TABLE_NAME = '{{%quest_user_progress}}';
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
            'user_id' => $this->integer(),
            'quest_id' => $this->integer(),
            'current_task_id' => $this->integer(),
            'is_completed' => $this->boolean()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quest_id`
        $this->createIndex(
            '{{%idx-quest_user_progress-quest_id}}',
            '{{%quest_user_progress}}',
            'quest_id'
        );

        // add foreign key for table `{{%quests}}`
        $this->addForeignKey(
            '{{%fk-quest_user_progress-quest_id}}',
            '{{%quest_user_progress}}',
            'quest_id',
            '{{%quests}}',
            'id',
            'CASCADE'
        );

        // creates index for column `current_task_id`
        $this->createIndex(
            '{{%idx-quest_user_progress-current_task_id}}',
            '{{%quest_user_progress}}',
            'current_task_id'
        );

        // add foreign key for table `{{%quest_tasks}}`
        $this->addForeignKey(
            '{{%fk-quest_user_progress-current_task_id}}',
            '{{%quest_user_progress}}',
            'current_task_id',
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
        // drops foreign key for table `{{%quests}}`
        $this->dropForeignKey(
            '{{%fk-quest_user_progress-quest_id}}',
            '{{%quest_user_progress}}'
        );

        // drops index for column `quest_id`
        $this->dropIndex(
            '{{%idx-quest_user_progress-quest_id}}',
            '{{%quest_user_progress}}'
        );

        // drops foreign key for table `{{%quest_tasks}}`
        $this->dropForeignKey(
            '{{%fk-quest_user_progress-current_task_id}}',
            '{{%quest_user_progress}}'
        );

        // drops index for column `current_task_id`
        $this->dropIndex(
            '{{%idx-quest_user_progress-current_task_id}}',
            '{{%quest_user_progress}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
