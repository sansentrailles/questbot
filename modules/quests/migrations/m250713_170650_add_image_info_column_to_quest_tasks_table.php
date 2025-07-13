<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles adding image_info to table `{{%quest_tasks}}`.
 */
class m250713_170650_add_image_info_column_to_quest_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quest_tasks}}', 'image_info', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%quest_tasks}}', 'image_info');
    }
}
