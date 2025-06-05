<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Class m250605_143439_drop_invalid_key_field
 */
class m250605_143439_drop_invalid_key_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%quest_user_progress}}', 'hint_id', $this->integer());

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
}
