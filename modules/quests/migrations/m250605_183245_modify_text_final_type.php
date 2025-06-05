<?php

namespace app\modules\quests\migrations;

use yii\db\Migration;

/**
 * Class m250605_183245_modify_text_final_type
 */
class m250605_183245_modify_text_final_type extends Migration
{
    const TABLE_NAME = '{{%quests}}';

    public function up()
    {
        $this->alterColumn(self::TABLE_NAME, 'text_final', 'text');
    }

    public function down() 
    {
        $this->alterColumn(self::TABLE_NAME,'text_final', 'varchar(255)' );
    }

}
