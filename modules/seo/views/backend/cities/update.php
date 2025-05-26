<?php

use app\modules\seo\Module;

/* @var $this yii\web\View */

$this->title = Module::t('common', 'SEO_CITY_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SEO_CITIES'), 'url' => ['/admin/seo/cities/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];
?>
<div class="update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
