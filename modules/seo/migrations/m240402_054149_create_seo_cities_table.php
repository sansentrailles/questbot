<?php

declare(strict_types=1);

namespace app\modules\seo\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seo_cities}}`.
 */
class m240402_054149_create_seo_cities_table extends Migration
{
    const TABLE_NAME = '{{%seo_cities}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'code' => $this->string(),
            'masks' => $this->text(),
            'is_visible' => $this->boolean()->defaultValue(false),
            'ord' => $this->integer()->defaultValue(0),
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
