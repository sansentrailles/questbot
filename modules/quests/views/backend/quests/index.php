<?php declare(strict_types=1);

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\quests\Module;
use app\modules\quests\models\Quest;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\ActionColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quests\models\QuestSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'QUESTS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-cube',
    'text' => $this->title,
];

$seoSection = 'quests';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'QUEST_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                'attribute' => 'image',
                'headerOptions' => ['width' => '15%'],
                'format' => 'raw',
                'value' => static fn ($model) => Html::img($model->getImagePath(), ['class' => 'img-responsive']),
            ],

            [
                'attribute' => 'title',
                'class' => LinkColumn::class,
                'action' => 'update',
            ],

            [
                'headerOptions' => ['width' => '10%'],
                'label' => Module::t('common', 'TASKS'),
                'format' => 'raw',
                'value' => static function ($model) {
                    $url = Url::to(['/admin/quests/tasks', 'questId' => $model->id]);
                    return Html::a(Module::t('common', 'TASKS'), $url);
                },
            ],

            [
                'headerOptions' => ['width' => '5%'],
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>
    <?php echo Html::endForm(); ?>
</div>
