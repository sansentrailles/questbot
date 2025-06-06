<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quest_stats}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quests}}`
 */
class m250606_111314_create_quest_stats_table extends Migration
{
    const TABLE_NAME = '{{%quest_stats}}';
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
            'start' => $this->integer(),
            'finish' => $this->integer(),
        ], $tableOptions);

        // creates index for column `quest_id`
        $this->createIndex(
            '{{%idx-quest_stats-quest_id}}',
            '{{%quest_stats}}',
            'quest_id'
        );

        // add foreign key for table `{{%quests}}`
        $this->addForeignKey(
            '{{%fk-quest_stats-quest_id}}',
            '{{%quest_stats}}',
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
            '{{%fk-quest_stats-quest_id}}',
            '{{%quest_stats}}'
        );

        // drops index for column `quest_id`
        $this->dropIndex(
            '{{%idx-quest_stats-quest_id}}',
            '{{%quest_stats}}'
        );

        $this->dropTable(self::TABLE_NAME);
    }
}
