<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding task_image_column_hint_count to table `{{%quest_stat_items}}`.
 */
class m250711_095941_add_task_image_column_hint_count_column_to_quest_stat_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quest_stat_items}}', 'image', $this->string());
        $this->addColumn('{{%quest_stat_items}}', 'hint_count', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quest_stat_items}}', 'image');
        $this->dropColumn('{{%quest_stat_items}}', 'hint_count');
    }
}
