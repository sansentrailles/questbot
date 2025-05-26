<?php

use app\modules\seo\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\seo\forms\backend\CityForm */

$this->title = Module::t('common', 'SEO_CITY_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SEO_CITIES'), 'url' => ['/admin/seo/cities']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];
?>
<div class="create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
