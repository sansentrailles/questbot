<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\cropper;

use yii\web\AssetBundle;

/**
 * Widget asset bundle.
 */
class Asset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@app/custom/widgets/backend/cropper/assets';

    // public $jsOptions = ['position' => \yii\web\View::POS_END];

    /**
     * {@inheritdoc}
     */
    public $css = [
        'css/cropper.min.css',
        'css/widget.css',
    ];

    /**
     * {@inheritdoc}
     */
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/cropper/2.3.2/cropper.min.js',
        'js/widget.js',
    ];

    /**
     * {@inheritdoc}
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
