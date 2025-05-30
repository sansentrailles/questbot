<?php

declare(strict_types=1);

$params =  require __DIR__ . '/../params.php';

return [
    'baseUrl' => '/',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'class' => '\yii\web\UrlManager',
    'rules' => [
        // put this rule above admin block
        'admin/<_a:(login|logout|signup|email-confirm|password-reset-request|password-reset|message)>' => 'user/default/<_a>',
        'admin/<_m:user>/<_c:default>/<_a:(login|logout|signup|email-confirm|password-reset-request|password-reset|message)>' => '<_m>/<_c>/error',

        [
            'class' => 'yii\web\GroupUrlRule',
            'prefix' => 'admin',
            'routePrefix' => 'admin',
            'rules' => [
                // '<_m:project>/<projectId:\d+>/<_a:photos>' => '<_m>/photo/index',
                // '<_m:embedded_gallery>/<id:\d+>/<_a:delete>' => '<_m>/photo/index',

                'help' => 'guide/default/view',
                'filemanager' => 'default/filemanager',

                '' => 'default/index',
                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<_a:(create)>' => '<_m>/default/<_a>',
                '<_m:[\w\-]+>/<id:\d+>' => '<_m>/default/view',
                '<_m:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_m>/default/<_a>',
                // '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
            ],
        ],

        '' => 'main/main/index',
        '<_a:error>' => 'main/default/<_a>',

        '/quests/handler' => 'quests/default/handler',

        // '<pageUri:[\w_\/-]+>'=>'page/default/view',
        // 'page/<_a>' => 'page/default/<_a>',

        '<_m:[\w\-]+>' => '<_m>/default/index',
        '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w-]+>' => '<_m>/<_c>/<_a>',
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
    ],
];
