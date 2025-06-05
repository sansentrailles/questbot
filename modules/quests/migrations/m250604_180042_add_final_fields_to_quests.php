<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Class m250604_180042_add_final_fields_to_quests
 */
class m250604_180042_add_final_fields_to_quests extends Migration
{
    const TABLE_NAME = '{{%quests}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'image_final', $this->string());
        $this->addColumn(self::TABLE_NAME, 'text_final', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'image_final');
        $this->dropColumn(self::TABLE_NAME, 'text_final');
    }
}
