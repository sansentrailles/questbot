<?php

declare(strict_types=1);

namespace app\modules\user;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/user/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/user/messages',
            'fileMap' => [
                'modules/user/common' => 'common.php',
                'modules/user/frontend' => 'frontend.php',
            ],
        ];
    }
}
