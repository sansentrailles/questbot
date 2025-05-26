<?php

declare(strict_types=1);

namespace app\modules\main;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/main/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/main/messages',
            'fileMap' => [
                'modules/main/common' => 'common.php',
                'modules/main/frontend' => 'frontend.php',
            ],
        ];

        $container = Yii::$container;
    }
}
