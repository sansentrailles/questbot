<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles dropping image from table `{{%quest_stat_items}}`.
 */
class m250712_165356_drop_image_column_from_quest_stat_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%quest_stat_items}}', 'image');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%quest_stat_items}}', 'image', $this->string());
    }
}
