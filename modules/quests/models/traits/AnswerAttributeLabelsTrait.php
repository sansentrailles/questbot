<?php

declare(strict_types=1);

namespace app\modules\quests\models\traits;

use app\modules\quests\Module;

trait AnswerAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'task_id'    => Module::t('common', 'TASK_ANSWER_TASK_ID'),
            'title'      => Module::t('common', 'TASK_ANSWER_TITLE'),
            'is_right'   => Module::t('common', 'TASK_ANSWER_IS_RIGHT'),
            'ord'        => Module::t('common', 'ORDER'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
