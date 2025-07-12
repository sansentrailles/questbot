<?php

declare(strict_types=1);

namespace app\modules\quests\models\traits;

use app\modules\quests\Module;

trait StatItemAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'            => Module::t('common', 'ID'),
            'task_id'       => Module::t('common', 'QUEST_STAT_ITEM_QUEST_ID'),
            'stat_id'       => Module::t('common', 'QUEST_STAT_ITEM_USER_ID'),
            'question'      => Module::t('common', 'QUEST_STAT_ITEM_QUESTION'),
            'task_answer'   => Module::t('common', 'QUEST_STAT_ITEM_TASK_ANSWER'),
            'user_answer'   => Module::t('common', 'QUEST_STAT_ITEM_USER_ANSWER'),
            'is_correct'    => Module::t('common', 'QUEST_STAT_ITEM_IS_CORRECT'),
            'hint_used'     => Module::t('common', 'QUEST_STAT_ITEM_HINT_USED'),
            'hint_count'    => Module::t('common', 'QUEST_STAT_ITEM_HINT_COUNT'),
        ];
    }
}
