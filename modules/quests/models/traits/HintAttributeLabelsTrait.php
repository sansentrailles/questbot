<?php

declare(strict_types=1);

namespace app\modules\quests\models\traits;

use app\modules\quests\Module;

trait HintAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID') ,
            'task_id'    => Module::t('common', 'HINT_TASK_ID') ,
            'text'       => Module::t('common', 'HINT_TEXT'),
            'image'      => Module::t('common', 'HINT_IMAGE') ,
            'imageFile'  => Module::t('common', 'HINT_IMAGE') ,
            'is_visible' => Module::t('common', 'IS_VISIBLE') ,
            'ord'        => Module::t('common', 'ORDER') ,
            'created_at' => Module::t('common', 'CREATED_AT') ,
            'updated_at' => Module::t('common', 'UPDATED_AT') ,
        ];
    }
}
