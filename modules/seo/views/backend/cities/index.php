<?php

use app\custom\widgets\backend\grid\UniqueToggleColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\seo\models\City;
use app\modules\seo\Module;
use app\custom\widgets\backend\grid\ToggleColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\LinkColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\seo\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('common', 'SEO_CITIES');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-map',
    'text' => $this->title,
];

?>

<div class="index">
    <p>
        <?= Html::a(Module::t('common', 'SEO_CITY_CREATE'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Html::beginForm(['cities/sort'], 'post', ['enctype' => 'multipart/form-data']) ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '5%'],
                ],

                [
                    'attribute' => 'title',
                    'class' => LinkColumn::class,
                    'action' => 'update',
                ],

                [
                    'attribute' => 'code',
                    'class' => LinkColumn::class,
                    'action' => 'update',
                ],

                [
                    'attribute' => 'ord',
                    'headerOptions' => ['width' => '5%'],
                    'contentOptions' => ['style' => 'text-align: center'],
                    'class' => InputColumn::class,
                    'name' => 'orders',
                ],

                [
                    'class' => ToggleColumn::class,
                    'contentOptions' => ['style' => 'text-align: center'],
                    'attribute' => 'is_visible',
                    'action' => 'toggle-visible',
                    'filter' => [
                        City::STATUS_INVISIBLE => Module::t('common', 'INVISIBLE'),
                        City::STATUS_VISIBLE => Module::t('common', 'VISIBLE'),
                    ],
                ],

                [
                    'class' => UniqueToggleColumn::class,
                    'contentOptions' => ['style' => 'text-align: center'],
                    'attribute' => 'is_default',
                    'action' => 'toggle-default',
                    'set' => 'main',
                    'filter' => [
                        City::STATE_DEFAULT => Module::t('common', 'STATE_DEFAULT'),
                        City::STATE_NOT_DEFAULT => Module::t('common', 'STATE_NOT_DEFAULT'),
                    ],
                ],

                [
                    'headerOptions' => ['width' => '5%'],
                    'class' => ActionColumn::class,
                    'contentOptions' => ['style' => 'text-align: center;'],
                ],
            ],
        ]); ?>

        <?= Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-sm btn-primary']) ?>

    <?= Html::endForm(); ?>
</div>
