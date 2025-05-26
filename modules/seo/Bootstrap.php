<?php

declare(strict_types=1);

namespace app\modules\seo;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/seo/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/seo/messages',
            'fileMap' => [
                'modules/seo/common' => 'common.php',
                'modules/seo/frontend' => 'frontend.php',
            ],
        ];
    }
}
