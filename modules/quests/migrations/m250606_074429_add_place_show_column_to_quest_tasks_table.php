<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding place_show to table `{{%quest_tasks}}`.
 */
class m250606_074429_add_place_show_column_to_quest_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quest_tasks}}', 'place_show', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quest_tasks}}', 'place_show');
    }
}
