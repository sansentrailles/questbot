<?php

declare(strict_types=1);

namespace app\modules\guide\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `guide_chapter`.
 */
class m191008_045923_create_guide_chapter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('guide_chapter', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'is_visible' => $this->boolean()->defaultValue(0),
            'ord' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('guide_chapter');
    }
}
