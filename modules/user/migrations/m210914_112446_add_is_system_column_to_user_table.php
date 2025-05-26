<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

/**
 * Handles adding is_system to table `{{%user}}`.
 */
class m210914_112446_add_is_system_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('{{%user}}', 'is_system', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('{{%user}}', 'is_system');
    }
}
