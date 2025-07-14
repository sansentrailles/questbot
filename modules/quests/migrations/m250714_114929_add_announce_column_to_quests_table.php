<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding announce to table `{{%quests}}`.
 */
class m250714_114929_add_announce_column_to_quests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quests}}', 'announce', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quests}}', 'announce');
    }
}
