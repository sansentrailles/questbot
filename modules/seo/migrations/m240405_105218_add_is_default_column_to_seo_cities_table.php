<?php

declare(strict_types=1);

namespace app\modules\seo\migrations;

use yii\db\Migration;

/**
 * Handles adding is_default to table `{{%seo_cities}}`.
 */
class m240405_105218_add_is_default_column_to_seo_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%seo_cities}}', 'is_default', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%seo_cities}}', 'is_default');
    }
}
