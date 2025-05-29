<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\quests\Module;
use app\modules\quests\models\Task;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quests\models\TaskSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'TASKS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-bars',
    'text' => $this->title,
];

$seoSection = 'quests';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'TASK_CREATE'), ['create', 'questId' => $quest->id], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo Html::beginForm(['tasks/sort'], 'post', ['enctype' => 'multipart/form-data']); ?>
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
                    'headerOptions' => ['width' => '20%'],
                    'attribute' => 'question',
                    'class' => LinkColumn::class,
                    'action' => 'update',
                ],

                [
                    'headerOptions' => ['width' => '20%'],
                    'attribute' => 'place',
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
                        Task::STATUS_INVISIBLE => Module::t('common', 'INVISIBLE'),
                        Task::STATUS_VISIBLE => Module::t('common', 'VISIBLE'),
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
