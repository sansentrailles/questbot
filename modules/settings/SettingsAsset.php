<?php

declare(strict_types=1);

namespace app\modules\settings;

use yii\web\AssetBundle;

class SettingsAsset extends AssetBundle
{
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $sourcePath = '@app/modules/settings/assets/';

    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css',
        'css/settings.css',
        // 'js/fancybox/jquery.fancybox-1.3.4.css'
    ];

    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js',
        'js/settings.js',
        // 'js/fancybox/jquery.fancybox-1.3.4.pack.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
