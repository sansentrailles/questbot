<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding hint_id to table `{{%quest_user_progress}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quest_user_progress}}`
 */
class m250605_105532_add_hint_id_column_to_quest_user_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quest_user_progress}}', 'hint_id', $this->integer());
        $this->addColumn('{{%quest_user_progress}}', 'hint_used', $this->integer());

        // creates index for column `hint_id`
        $this->createIndex(
            '{{%idx-quest_user_progress-hint_id}}',
            '{{%quest_user_progress}}',
            'hint_id'
        );

        // add foreign key for table `{{%quest_user_progress}}`
        $this->addForeignKey(
            '{{%fk-quest_user_progress-hint_id}}',
            '{{%quest_user_progress}}',
            'hint_id',
            '{{%quest_user_progress}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%quest_user_progress}}`
        $this->dropForeignKey(
            '{{%fk-quest_user_progress-hint_id}}',
            '{{%quest_user_progress}}'
        );

        // drops index for column `hint_id`
        $this->dropIndex(
            '{{%idx-quest_user_progress-hint_id}}',
            '{{%quest_user_progress}}'
        );

        $this->dropColumn('{{%quest_user_progress}}', 'hint_id');
        $this->dropColumn('{{%quest_user_progress}}', 'hint_used');
    }
}
