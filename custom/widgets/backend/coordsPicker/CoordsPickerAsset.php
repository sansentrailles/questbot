<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\coordsPicker;

use yii\web\AssetBundle;

class CoordsPickerAsset extends AssetBundle
{
    public $sourcePath = '@app/custom/widgets/backend/coordsPicker/assets';
    public $js = [
        'coordsPicker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
