<?php

declare(strict_types=1);

namespace app\modules\quests\models\traits;

use app\modules\quests\Module;

trait StatAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'       => Module::t('common', 'ID'),
            'quest_id' => Module::t('common', 'QUEST_STAT_QUEST_ID'),
            'user_id'  => Module::t('common', 'QUEST_STAT_USER_ID'),
            'start'    => Module::t('common', 'QUEST_STAT_START'),
            'finish'   => Module::t('common', 'QUEST_STAT_FINISH'),
            'uuid'     => Module::t('common', 'QUEST_STAT_UUID'),
        ];
    }
}
