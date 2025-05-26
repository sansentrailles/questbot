<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use yii\web\AssetBundle;

class UniqueToggleColumnAsset extends AssetBundle
{
    public $sourcePath = '@app/custom/widgets/backend/grid/assets';
    public $js = [
        'uniqueToggleColumn.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
