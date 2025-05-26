<?php

declare(strict_types=1);

namespace app\modules\main\models\traits;

use app\modules\main\Module;

trait SliderItemAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Module::t('common', 'ID'),
            'type'        => Module::t('common', 'MAIN_SLIDER_ITEM_TYPE'),
            'image'       => Module::t('common', 'MAIN_SLIDER_ITEM_IMAGE'),
            'imageFile'   => Module::t('common', 'MAIN_SLIDER_ITEM_IMAGE'),
            'video'       => Module::t('common', 'MAIN_SLIDER_ITEM_VIDEO'),
            'videoFile'   => Module::t('common', 'MAIN_SLIDER_ITEM_VIDEO'),
            'is_visible'  => Module::t('common', 'IS_VISIBLE'),
            'ord'         => Module::t('common', 'ORDER'),
            'created_at'  => Module::t('common', 'CREATED_AT'),
            'updated_at'  => Module::t('common', 'UPDATED_AT'),
        ];
    }
}
