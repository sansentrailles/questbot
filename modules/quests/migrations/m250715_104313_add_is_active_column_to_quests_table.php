<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding is_active to table `{{%quests}}`.
 */
class m250715_104313_add_is_active_column_to_quests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quests}}', 'is_active', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quests}}', 'is_active');
    }
}
