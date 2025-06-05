<?php declare(strict_types=1);

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\quests\Module;
use app\modules\quests\models\Hint;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\ToggleColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quests\models\HintSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'HINTS');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUESTS'), 'url' => ['/admin/quests/quests']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TASKS').": ". $task->quest->title, 'url' => ['/admin/quests/tasks', 'questId' => $task->quest_id]];
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-info',
    'text' => $this->title,
];

?>
<div class="index">

    <p>
        <span class="text-blue"><b>Подсказки для задания: <?= $task->question ?></b></span>
    </p>

    <p>
        <?php echo Html::a(Module::t('common', 'HINT_CREATE'), ['create', 'taskId' => $task->id], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo Html::beginForm(['hints/sort'], 'post', ['enctype' => 'multipart/form-data']); ?>
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
                    'attribute' => 'text',
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
                        Hint::STATUS_INVISIBLE => Module::t('common', 'INVISIBLE'),
                        Hint::STATUS_VISIBLE => Module::t('common', 'VISIBLE'),
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
