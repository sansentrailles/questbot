<?php declare(strict_types=1);

use app\custom\helpers\RouteHelper;
use app\modules\feedback\Module as FeedbackModule;
use app\modules\user\Module as UserModule;
use app\modules\settings\Module as SettingsModule;
use app\modules\tyres\Module as TyresModule;
use app\modules\about\Module as AboutModule;
use app\modules\social\Module as SocialModule;
use app\modules\pages\Module as PageModule;
use app\modules\quests\Module as QuestModule;

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <?php echo dmstr\widgets\Menu::widget(
            [
                'options' => [
                    'class' => 'sidebar-menu',
                    'data-widget' => 'tree',
                ],
                'items' => [
                    // ['label' => AdminModule::t('common', 'ADMIN_SECTIONS') . ' ' . Yii::$app->name, 'options' => ['class' => 'header']],

                    [
                        'label' => UserModule::t('common', 'ADMIN_USERS'),
                        'icon' => 'users',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('user'),
                        // 'visible' => Yii::$app->user->can('dev'),
                        'items' => [
                            [
                                'label' => UserModule::t('common', 'USER_LIST'),
                                'icon' => 'list-ol',
                                'url' => ['/admin/user/'],
                                'active'=> RouteHelper::isRoute('user/default/index'),
                            ],

                            [
                                'label' => UserModule::t('common', 'PERMISSIONS'),
                                'icon' => 'key',
                                'url' => ['/admin/user/permissions'],
                                'active'=> RouteHelper::isRoute('user/permissions/index'),
                            ],

                            [
                                'label' => UserModule::t('common', 'ROLES'),
                                'icon' => 'user-secret',
                                'url' => ['/admin/user/roles'],
                                'active'=> RouteHelper::isRoute('user/roles/index'),
                            ],
                        ],
                    ],

                    [
                        'label' => QuestModule::t('common', 'QUESTS'),
                        'icon' => 'question',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('quests'),
                        'items' => [
                            [
                                'label' => QuestModule::t('common', 'QUESTS_LIST'),
                                'icon' => 'bars',
                                'url' => ['/admin/quests/quests'],
                                'active'=> RouteHelper::isRoute('quests/quests'),
                                // 'visible' => Yii::$app->user->can('dev'),
                            ],
                        ],
                    ],

                    [
                        'label' => SettingsModule::t('common', 'SETTINGS'),
                        'icon' => 'gears',
                        'url' => '#',
                        'active'=> RouteHelper::isModule('settings'),
                        'items' => [
                            [
                                'label' => SettingsModule::t('common', 'SETTING_GROUPS'),
                                'icon' => 'bars',
                                'url' => ['/admin/settings/groups'],
                                'active'=> RouteHelper::isRoute('settings/groups'),
                                // 'visible' => Yii::$app->user->can('dev'),
                            ],
                            [
                                'label' => SettingsModule::t('common', 'SETTINGS'),
                                'icon' => 'gear',
                                'url' => ['/admin/settings'],
                                'active'=> RouteHelper::isRoute('settings'),
                            ],
                        ],
                    ],
                ],
            ]
        ); ?>

    </section>

</aside>
