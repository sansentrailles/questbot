<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding answer to table `{{%user_progress}}`.
 */
class m250604_171805_add_answer_column_to_user_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_progress}}', 'answer', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_progress}}', 'answer');
    }
}
