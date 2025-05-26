<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\delete;

use yii\web\AssetBundle;

class DeleteAsset extends AssetBundle
{
    public $sourcePath = '@app/custom/widgets/backend/delete';
    public $css = [];
    public $js = ['assets/widget.delete.js'];
    public $depends = [];
}
