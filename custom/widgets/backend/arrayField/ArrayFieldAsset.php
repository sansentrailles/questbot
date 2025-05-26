<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\arrayField;

use yii\web\AssetBundle;

class ArrayFieldAsset extends AssetBundle
{
    public $sourcePath = '@app/custom/widgets/backend/arrayField/assets';
    public $js = [
        'arrayField.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
