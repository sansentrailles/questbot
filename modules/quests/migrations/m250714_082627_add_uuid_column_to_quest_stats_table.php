<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding uuid to table `{{%quest_stats}}`.
 */
class m250714_082627_add_uuid_column_to_quest_stats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quest_stats}}', 'uuid', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quest_stats}}', 'uuid');
    }
}
