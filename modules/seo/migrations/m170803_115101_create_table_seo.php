<?php

declare(strict_types=1);

namespace app\modules\seo\migrations;

use yii\db\Migration;

class m170803_115101_create_table_seo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%seo}}', [
            'id' => $this->primaryKey(),
            'ref_id' => $this->integer(),
            'section' => $this->string(),
            'title' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->string(),
            'text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-seo-ref_id-section', '{{%seo}}', ['ref_id', 'section']);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable('{{%seo}}');
    }
}
