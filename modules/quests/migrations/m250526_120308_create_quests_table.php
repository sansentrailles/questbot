<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quests}}`.
 */
class m250526_120308_create_quests_table extends Migration
{
    const TABLE_NAME = '{{%quests}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'image' => $this->string(),
            'title' => $this->string(),
            'code' => $this->string(),
            // 'desc' => $this->text(),
            'desc' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'),
            'date' => $this->timestamp(),
            'limit' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
