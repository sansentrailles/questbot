<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quest_tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quests}}`
 */
class m250529_090828_create_quest_tasks_table extends Migration
{
    const TABLE_NAME = '{{%quest_tasks}}';
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
            'quest_id' => $this->integer(),
            'question' => $this->text(),
            'image' => $this->string(),
            'answer' => $this->string(),
            'type' => $this->smallInteger(),
            'place' => $this->text(),
            'address' => $this->string(),
            'longitude' => $this->string(),
            'latitude' => $this->string(),
            'message' => $this->text(),
            'is_visible' => $this->boolean()->defaultValue(false),
            'ord' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quest_id`
        $this->createIndex(
            '{{%idx-quest_tasks-quest_id}}',
            '{{%quest_tasks}}',
            'quest_id'
        );

        // add foreign key for table `{{%quests}}`
        $this->addForeignKey(
            '{{%fk-quest_tasks-quest_id}}',
            '{{%quest_tasks}}',
            'quest_id',
            '{{%quests}}',
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
            '{{%fk-quest_tasks-quest_id}}',
            '{{%quest_tasks}}'
        );

        // drops index for column `quest_id`
        $this->dropIndex(
            '{{%idx-quest_tasks-quest_id}}',
            '{{%quest_tasks}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
