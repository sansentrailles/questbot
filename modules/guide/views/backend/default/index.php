<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ToggleColumn;
use app\modules\guide\models\GuideChapter;
use app\modules\guide\Module;
use yii\grid\GridView;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $searchModel app\modules\guide\models\GuideChapterSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'GUIDE_CHAPTERS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-commenting',
    'text' => $this->title,
];

?>
<div class="news-index">
    <p>
        <?php echo Html::a(Module::t('common', 'GUIDE_CHAPTER_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo Html::beginForm(['default/sort'], 'post', ['enctype' => 'multipart/form-data']); ?>

        <?php echo GridView::widget([
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
                    'attribute' => 'ord',
                    'headerOptions' => ['width' => '5%'],
                    'contentOptions' => ['style' => 'text-align: center'],
                    'class' => InputColumn::class,
                    'name' => 'guideChapterOrders',
                ],

                [
                    'class' => ToggleColumn::class,
                    'contentOptions' => ['style' => 'text-align: center'],
                    'attribute' => 'is_visible',
                    'action' => 'toggle-visible',
                    'filter' => [
                        GuideChapter::STATUS_INVISIBLE => Module::t('common', 'ITEM_INVISIBLE'),
                        GuideChapter::STATUS_VISIBLE => Module::t('common', 'ITEM_VISIBLE'),
                    ],
                ],

                [
                    'headerOptions' => ['width' => '5%'],
                    'class' => ActionColumn::class,
                    'contentOptions' => ['style' => 'text-align: center;'],
                ],
            ],
        ]); ?>

        <?php echo Html::submitButton(Module::t('common', 'BUTTON_SAVE'), ['class' => 'btn btn-sm btn-primary']); ?>

    <?php echo Html::endForm(); ?>
</div>
