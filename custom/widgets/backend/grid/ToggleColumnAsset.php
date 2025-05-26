<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use yii\web\AssetBundle;

class ToggleColumnAsset extends AssetBundle
{
    public $sourcePath = '@app/custom/widgets/backend/grid/assets';
    public $js = [
        'toggleColumn.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
