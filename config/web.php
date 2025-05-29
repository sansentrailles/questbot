<?php

declare(strict_types=1);

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$modules = require __DIR__ . '/inner/_modules.php';
$urls = require __DIR__ . '/inner/_urls.php';
$buckets = require __DIR__ . '/inner/_buckets.php';
$devMailer = require __DIR__ . '/mailer/_dev.php';
$prodMailer = require __DIR__ . '/mailer/_prod.php';

require __DIR__ . '/inner/_layout.php';

$config = [
    'id' => 'basic',
    'name' => 'Base',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        // base modules
        'app\modules\admin\Bootstrap',
        'app\modules\user\Bootstrap',
        'app\modules\settings\Bootstrap',
        'app\modules\quests\Bootstrap',
    ],
    'language' => 'ru',
    'timezone' => 'Asia/Yekaterinburg',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'modules' => $modules,

    'components' => [
        'setting' => [
            'class' => 'app\modules\settings\components\Setting',
            'time' => 3600,
            'caching' => true,
        ],

        'inflection' => [
            'class' => 'wapmorgan\yii2inflection\Inflection',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => YII_DEBUG,
        ],
        // 'fileStorage' => [
        //     'class' => 'yii2tech\filestorage\local\Storage',
        //     'basePath' => '@webroot/files',
        //     'baseUrl' => '@web/files',
        //     'buckets' => $buckets,
        // ],
        'request' => [
            'class' => 'yii\web\Request',
            // 'class' => 'app\modules\catalog\components\Request',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'k0xChG06U7HTgyCu2RYYzy7d_Y49kssbfd',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            // ...
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    // ...
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'mailer' => YII_DEBUG ? $devMailer : $prodMailer,
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => $urls,
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
