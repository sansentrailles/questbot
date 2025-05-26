<?php declare(strict_types=1);

use app\modules\admin\Module as AdminModule;
use yii\helpers\Html;

// @var $this \yii\web\View
// @var $content string
?>

<header class="main-header">
    <?php
        $shortName = Yii::$app->params['shortName'] ?? 'basic';
$siteName = Yii::$app->params['siteName'] ?? 'basic';
$adminLabel = Yii::$app->params['adminLabel'] ?? 'basic';
?>
    <?php echo Html::a('<span class="logo-mini">' . $shortName . '</span><span class="logo-lg">' . $adminLabel . '</span>', Yii::$app->homeUrl, ['class' => 'logo']); ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li>
                    <a href="/admin/help" target="_blank"><i class="fa fa-question"></i> Справка</a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $directoryAsset; ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php // = Yii::$app->user->identity->fullname?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $directoryAsset; ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>

                            <p>
                                <?php // = Yii::$app->user->identity->fullname?> administrator
                                <?php /* <small><?= AdminModule::t('common', 'TEXT_MEMBER_SINCE') ?> </small> */ ?> <?php // = date('Y.m.d', Yii::$app->user->identity->created_at)?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?php echo Html::a(
                                    AdminModule::t('common', 'ACTION_SIGN_OUT'),
                                    ['/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ); ?>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
