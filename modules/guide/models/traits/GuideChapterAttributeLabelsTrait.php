<?php

declare(strict_types=1);

namespace app\modules\guide\models\traits;

use app\modules\guide\Module;

trait GuideChapterAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'ID'),
            'title'      => Module::t('common', 'GUIDE_CHAPTER_TITLE'),
            'text'       => Module::t('common', 'GUIDE_CHAPTER_TEXT'),
            'ord'        => Module::t('common', 'ORDER'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
