<?php

declare(strict_types=1);

namespace app\modules\settings\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `setting`.
 */
class _m180717_085209_create_setting_table extends Migration
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

        $this->createTable('setting', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'desc' => $this->text(),
            'group' => $this->string(),
            'key' => $this->string(),
            'type_id' => $this->integer(),
            'is_multiple' => $this->boolean()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('setting');
    }
}
