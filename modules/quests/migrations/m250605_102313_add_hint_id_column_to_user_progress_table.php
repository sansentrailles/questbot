<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding hint_id to table `{{%user_progress}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user_progress}}`
 */
class m250605_102313_add_hint_id_column_to_user_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_progress}}', 'hint_id', $this->integer());
        $this->addColumn('{{%user_progress}}', 'hint_used', $this->integer()->defaultValue(0));

        // creates index for column `hint_id`
        $this->createIndex(
            '{{%idx-user_progress-hint_id}}',
            '{{%user_progress}}',
            'hint_id'
        );

        // add foreign key for table `{{%user_progress}}`
        $this->addForeignKey(
            '{{%fk-user_progress-hint_id}}',
            '{{%user_progress}}',
            'hint_id',
            '{{%user_progress}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user_progress}}`
        $this->dropForeignKey(
            '{{%fk-user_progress-hint_id}}',
            '{{%user_progress}}'
        );

        // drops index for column `hint_id`
        $this->dropIndex(
            '{{%idx-user_progress-hint_id}}',
            '{{%user_progress}}'
        );

        $this->dropColumn('{{%user_progress}}', 'hint_id');
        $this->dropColumn('{{%user_progress}}', 'hint_used');
    }
}
