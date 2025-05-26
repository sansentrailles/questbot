<?php

declare(strict_types=1);

namespace app\modules\seo\migrations;

use yii\db\Migration;

/**
 * Handles adding show_text to table `seo`.
 */
class m181009_044012_add_show_text_column_to_seo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->addColumn('seo', 'show_text', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('seo', 'show_text');
    }
}
