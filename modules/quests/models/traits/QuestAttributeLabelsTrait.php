<?php

declare(strict_types=1);

namespace app\modules\quests\models\traits;

use app\modules\quests\Module;

trait QuestAttributeLabelsTrait
{
    public function attributeLabels()
    {
        return [
            'id'             => Module::t('common', 'ID'),
            'title'          => Module::t('common', 'QUEST_TITLE'),
            'desc'           => Module::t('common', 'QUEST_DESC'),
            'text_final'     => Module::t('common', 'QUEST_TEXT_FINAL'),
            'help'           => Module::t('common', 'QUEST_HELP'),
            'code'           => Module::t('common', 'QUEST_CODE'),
            'limit'          => Module::t('common', 'QUEST_LIMIT'),
            'date'           => Module::t('common', 'QUEST_DATE'),
            'image_final'    => Module::t('common', 'QUEST_IMAGE_FINAL'),
            'imageFinalFile' => Module::t('common', 'QUEST_IMAGE_FINAL'),
            'image'          => Module::t('common', 'QUEST_IMAGE'),
            'imageFile'      => Module::t('common', 'QUEST_IMAGE'),
            'is_visible'     => Module::t('common', 'QUEST_IS_ACTIVE'),
            'ord'            => Module::t('common', 'ORDER'),
            'created_at'     => Module::t('common', 'CREATED_AT'),
            'updated_at'     => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
