<?php

declare(strict_types=1);

namespace app\modules\seo\models\traits;

use app\modules\seo\Module;

trait SeoAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('common', 'SEO_ID'),
            'ref_id' => Module::t('common', 'SEO_REF_ID'),
            'section' => Module::t('common', 'SEO_SECTION'),
            'title' => Module::t('common', 'SEO_TITLE'),
            'keywords' => Module::t('common', 'SEO_KEYWORDS'),
            'description' => Module::t('common', 'SEO_DESCRIPTION'),
            'text' => Module::t('common', 'SEO_TEXT'),
            'show_text' => Module::t('common', 'SEO_SHOW_TEXT'),
            'created_at' => Module::t('common', 'PAGES_CREATED_AT'),
            'updated_at' => Module::t('common', 'PAGES_UPDATED_AT'),
        ];
    }
}
