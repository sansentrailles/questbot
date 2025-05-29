<?php

declare(strict_types=1);

$params =  require __DIR__ . '/../params.php';
require __DIR__ . '/_layout.php';

return [
    'admin' => [
        'class' => 'app\modules\admin\Module',
        'layout' => $layoutBackend,
        'controllerNamespace' => 'app\modules\admin\controllers\backend',
        'viewPath' => '@app/modules/admin/views/backend',
        'layout' => $layoutBackend,

        'modules' => [
            'main' => [
                'class' => 'app\modules\main\Module',
                'controllerNamespace' => 'app\modules\main\controllers\backend',
                'viewPath' => '@app/modules/main/views/backend',
                'layout' => $layoutBackend,
            ],

            'user' => [
                'class' => 'app\modules\user\Module',
                'controllerNamespace' => 'app\modules\user\controllers\backend',
                'viewPath' => '@app/modules/user/views/backend',
                'layout' => $layoutBackend,
            ],

            'settings' => [
                'class' => 'app\modules\settings\Module',
                'controllerNamespace' => 'app\modules\settings\controllers\backend',
                'viewPath' => '@app/modules/settings/views/backend',
                'layout' => $layoutBackend,
            ],

            'tyres' => [
                'class' => 'app\modules\tyres\Module',
                'controllerNamespace' => 'app\modules\tyres\controllers\backend',
                'viewPath' => '@app/modules/tyres/views/backend',
                'layout' => $layoutBackend,
            ],

            'feedback' => [
                'class' => 'app\modules\feedback\Module',
                'controllerNamespace' => 'app\modules\feedback\controllers\backend',
                'viewPath' => '@app/modules/feedback/views/backend',
                'layout' => $layoutBackend,
            ],

            'about' => [
                'class' => 'app\modules\about\Module',
                'controllerNamespace' => 'app\modules\about\controllers\backend',
                'viewPath' => '@app/modules/about/views/backend',
                'layout' => $layoutBackend,
            ],

            'social' => [
                'class' => 'app\modules\social\Module',
                'controllerNamespace' => 'app\modules\social\controllers\backend',
                'viewPath' => '@app/modules/social/views/backend',
                'layout' => $layoutBackend,
            ],

            'pages' => [
                'class' => 'app\modules\pages\Module',
                'controllerNamespace' => 'app\modules\pages\controllers\backend',
                'viewPath' => '@app/modules/pages/views/backend',
                'layout' => $layoutBackend,
            ],

            'quests' => [
                'class' => 'app\modules\quests\Module',
                'controllerNamespace' => 'app\modules\quests\controllers\backend',
                'viewPath' => '@app/modules/quests/views/backend',
                'layout' => $layoutBackend,
            ],

            // 'guide' => [
            //     'class' => 'app\modules\guide\Module',
            //     'controllerNamespace' => 'app\modules\guide\controllers\backend',
            //     'viewPath' => '@app/modules/guide/views/backend',
            //     'layout' => $layoutBackend,
            // ],
        ],
    ],

    'main' => [
        'class' => 'app\modules\main\Module',
        'controllerNamespace' => 'app\modules\main\controllers\frontend',
        'viewPath' => '@app/modules/main/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'user' => [
        'class' => 'app\modules\user\Module',
        'controllerNamespace' => 'app\modules\user\controllers\frontend',
        'viewPath' => '@app/modules/user/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'tyres' => [
        'class' => 'app\modules\tyres\Module',
        'controllerNamespace' => 'app\modules\tyres\controllers\frontend',
        'viewPath' => '@app/modules/tyres/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'about' => [
        'class' => 'app\modules\about\Module',
        'controllerNamespace' => 'app\modules\about\controllers\frontend',
        'viewPath' => '@app/modules/about/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'feedback' => [
        'class' => 'app\modules\feedback\Module',
        'controllerNamespace' => 'app\modules\feedback\controllers\frontend',
        'viewPath' => '@app/modules/feedback/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'social' => [
        'class' => 'app\modules\social\Module',
        'controllerNamespace' => 'app\modules\social\controllers\frontend',
        'viewPath' => '@app/modules/social/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'seo' => [
        'class' => 'app\modules\seo\Module',
        'controllerNamespace' => 'app\modules\seo\controllers\frontend',
        'viewPath' => '@app/modules/seo/views/frontend',
        'layout' => $layoutFrontend,
    ],

    'pages' => [
        'class' => 'app\modules\pages\Module',
        'controllerNamespace' => 'app\modules\pages\controllers\frontend',
        'viewPath' => '@app/modules/pages/views/frontend',
        'layout' => $layoutFrontend,
    ],
];
