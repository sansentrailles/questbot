<?php

declare(strict_types=1);

namespace app\modules\guide;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/guide/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/guide/messages',
            'fileMap' => [
                'modules/guide/common' => 'common.php',
                'modules/guide/frontend' => 'frontend.php',
            ],
        ];
    }
}
