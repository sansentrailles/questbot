<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding answer to table `{{%quest_user_progress}}`.
 */
class m250604_173946_add_answer_column_to_quest_user_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quest_user_progress}}', 'answer', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quest_user_progress}}', 'answer');
    }
}
