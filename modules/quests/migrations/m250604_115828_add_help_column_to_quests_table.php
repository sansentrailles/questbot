<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding help to table `{{%quests}}`.
 */
class m250604_115828_add_help_column_to_quests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quests}}', 'help', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quests}}', 'help');
    }
}
