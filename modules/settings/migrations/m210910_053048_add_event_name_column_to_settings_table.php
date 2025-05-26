<?php

declare(strict_types=1);

namespace app\modules\settings\migrations;

use yii\db\Migration;

/**
 * Handles adding event_name to table `{{%settings}}`.
 */
class m210910_053048_add_event_name_column_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('{{%settings}}', 'event_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('{{%settings}}', 'event_name');
    }
}
