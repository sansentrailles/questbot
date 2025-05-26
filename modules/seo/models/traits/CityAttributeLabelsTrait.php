<?php

declare(strict_types=1);

namespace app\modules\seo\models\traits;

use app\modules\seo\Module;

trait CityAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('common', 'SEO_CITY_ID'),
            'title'      => Module::t('common', 'SEO_CITY_TITLE'),
            'code'       => Module::t('common', 'SEO_CITY_CODE'),
            'is_default' => Module::t('common', 'SEO_CITY_IS_DEFAULT'),
            'is_visible' => Module::t('common', 'IS_VISIBLE'),
            'ord'        => Module::t('common', 'ORDER'),
            'created_at' => Module::t('common', 'CREATED_AT'),
            'updated_at' => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
