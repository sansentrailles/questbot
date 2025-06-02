<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding is_visible to table `{{%quests}}`.
 */
class m250602_084303_add_is_visible_column_to_quests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quests}}', 'is_visible', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quests}}', 'is_visible');
    }
}
