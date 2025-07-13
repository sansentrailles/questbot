<?php

declare(strict_types=1);

namespace app\modules\quests\models\traits;

use app\modules\quests\Module;

trait TaskAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'            => Module::t('common', 'ID'),
            'quest_id'      => Module::t('common', 'TASK_QUEST_ID'),
            'question'      => Module::t('common', 'TASK_QUESTION'),
            'answer'        => Module::t('common', 'TASK_ANSWER'),
            'type'          => Module::t('common', 'TASK_TYPE'),
            'place'         => Module::t('common', 'TASK_PLACE'),
            'address'       => Module::t('common', 'TASK_ADDRESS'),
            'longitude'     => Module::t('common', 'TASK_LONGITUDE'),
            'latitude'      => Module::t('common', 'TASK_LATITUDE'),
            'message'       => Module::t('common', 'TASK_MESSAGE'),
            'image'         => Module::t('common', 'TASK_IMAGE'),
            'imageFile'     => Module::t('common', 'TASK_IMAGE'),
            'image_info'    => Module::t('common', 'TASK_IMAGE_INFO'),
            'imageInfoFile' => Module::t('common', 'TASK_IMAGE_INFO'),
            'place_show'    => Module::t('common', 'TASK_PLACE_SHOW'),
            'is_visible'    => Module::t('common', 'IS_VISIBLE'),
            'ord'           => Module::t('common', 'ORDER'),
            'created_at'    => Module::t('common', 'CREATED_AT'),
            'updated_at'    => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
