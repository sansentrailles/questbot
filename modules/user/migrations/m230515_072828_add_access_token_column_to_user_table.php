<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

/**
 * Handles adding access_token to table `{{%user}}`.
 */
class m230515_072828_add_access_token_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
