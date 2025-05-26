<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use app\modules\user\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m161225_153353_create_user_table extends Migration
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

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email_confirm_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string(),
            'firstname' => $this->string()->notNull(),
            'lastname' => $this->string()->notNull(),
            'phone' => $this->string(),

            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_WAIT),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable('{{%user}}');
    }
}
