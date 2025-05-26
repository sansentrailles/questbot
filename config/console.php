<?php

declare(strict_types=1);

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$buckets = require __DIR__ . '/inner/_buckets.php';
$urls = require __DIR__ . '/inner/_urls.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\modules\admin\Bootstrap',
        'app\modules\user\Bootstrap',
    ],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'search' => [
            'class' => 'himiklab\yii2\search\Search',
            'models' => [
                'app\modules\news_lang\models\NewsItemLang',
            ],
        ],
        'fileStorage' => [
            'class' => 'yii2tech\filestorage\local\Storage',
            'basePath' => '@webroot/files',
            'baseUrl' => '/files',
            'buckets' => $buckets,
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
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
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@app/custom/views/migration/migration.php',
            'generatorTemplateFiles' => [
                'create_table' => '@app/custom/views/migration/createTableMigration.php',
                'drop_table' => '@app/custom/views/migration/dropTableMigration.php',
                'add_column' => '@app/custom/views/migration/addColumnMigration.php',
                'drop_column' => '@app/custom/views/migration/dropColumnMigration.php',
                // 'create_junction' => 'app/custom/views/migration/createJunctionMigration.php'
            ],
        ],
        'user' => [ // user generation command line.
            'class' => 'app\modules\user\controllers\console\UserController',
        ],
        'role' => [ // roles assigns command line.
            'class' => 'app\modules\user\controllers\console\RoleController',
        ],
        'rbac' => [ // rbac init roles, permissions, assigns.
            'class' => 'app\modules\admin\commands\RbacController',
        ],
        'migrate-rbac' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'migration_rbac',
            'migrationPath' => '@yii/rbac/migrations',
        ],
        'migrate-user' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\user\migrations'],
            'migrationTable' => 'migration_user',
        ],

        'migrate-settings' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\settings\migrations'],
            'migrationTable' => 'migration_settings',
        ],

        'migrate-guide' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\guide\migrations'],
            'migrationTable' => 'migration_guide',
        ],

        'migrate-main' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\main\migrations'],
            'migrationTable' => 'migration_main',
        ],

        'migrate-tyres' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\tyres\migrations'],
            'migrationTable' => 'migration_tyres',
        ],

        'migrate-feedback' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\feedback\migrations'],
            'migrationTable' => 'migration_feedback',
        ],

        'migrate-about' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\about\migrations'],
            'migrationTable' => 'migration_about',
        ],

        'migrate-social' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\social\migrations'],
            'migrationTable' => 'migration_social',
        ],

        'migrate-pages' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\pages\migrations'],
            'migrationTable' => 'migration_pages',
        ],

        'migrate-seo' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\modules\seo\migrations'],
            'migrationTable' => 'migration_seo',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
