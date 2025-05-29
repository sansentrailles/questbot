<?php

declare(strict_types=1);

namespace app\modules\quests;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/quests/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/quests/messages',
            'fileMap' => [
                'modules/quests/common' => 'common.php',
                'modules/quests/frontend' => 'frontend.php',
            ],
        ];

    }
}
