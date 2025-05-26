<?php

declare(strict_types=1);

namespace app\modules\settings;

use app\modules\settings\services\SettingEmailValueService;
use app\modules\settings\services\SettingFormatedTextValueService;
use app\modules\settings\services\SettingSelectedFileValueService;
use app\modules\settings\services\SettingStringValueService;
use app\modules\settings\services\SettingTextValueService;
use app\modules\settings\services\SettingUploadedFileValueService;
use app\modules\settings\services\SettingUrlValueService;
use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $app->i18n->translations['modules/settings/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/settings/messages',
            'fileMap' => [
                'modules/settings/common' => 'common.php',
                'modules/settings/frontend' => 'frontend.php',
            ],
        ];

        Yii::$container->setSingleton('settingStringValueService', SettingStringValueService::class);
        Yii::$container->setSingleton('settingEmailValueService', SettingEmailValueService::class);
        Yii::$container->setSingleton('settingFormatedTextValueService', SettingFormatedTextValueService::class);
        Yii::$container->setSingleton('settingTextValueService', SettingTextValueService::class);
        Yii::$container->setSingleton('settingUrlValueService', SettingUrlValueService::class);
        Yii::$container->setSingleton('settingUploadedFileValueService', SettingUploadedFileValueService::class);
        Yii::$container->setSingleton('settingSelectedFileValueService', SettingSelectedFileValueService::class);
    }
}
