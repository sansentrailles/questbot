<?php

declare(strict_types=1);

namespace app\modules\user\models\traits;

use app\modules\user\Module;

trait PermissionAttributeLabelsTrait
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Module::t('common', 'ID'),
            'name'        => Module::t('common', 'PERMISSION_NAME'),
            'description' => Module::t('common', 'PERMISSION_DESCRIPTION'),
        ];
    }
}
