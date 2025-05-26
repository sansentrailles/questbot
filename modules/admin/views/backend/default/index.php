<?php

use app\modules\seo\widgets\backend\seo\SeoWidget;

?>

<div class="admin-default-index">
    <h1><?php echo Yii::$app->params['siteName']; ?></h1>
    <h2>
        Добро пожаловать в административную панель сайта
    </h2>
    <h3 class="text-light-blue">
        Для навигации под административной панели используйте меню слева
    </h3>

    <br>
    <br>
    <br>

    <div class="row">
        <div class="col-md-2">SEO главной страницы</div>
        <div class="col-md-2">
            <p>
                <?php //= SeoWidget::widget(['refId' => 0, 'section' => 'main'])?>
            </p>
        </div>
    </div>
</div>
