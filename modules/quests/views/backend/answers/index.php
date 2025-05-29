<?php declare(strict_types=1);

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\quests\Module;
use app\modules\quests\models\Answer;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\InputColumn;
use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\UniqueToggleColumn;

// @var $this yii\web\View
// @var $searchModel app\modules\quests\models\AnswerSearch
// @var $dataProvider yii\data\ActiveDataProvider

$quest = $task->quest;

$this->title = Module::t('common', 'TASK_ANSWERS');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUESTS'), 'url' => ['/admin/quests/quests']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TASKS').": ". $quest->title, 'url' => ['/admin/quests/tasks', 'questId' => $quest->id]];
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-bars',
    'text' => $this->title,
];

$seoSection = 'quests';

?>
<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'TASK_ANSWER_CREATE'), ['create', 'taskId' => $task->id], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo Html::beginForm(['answers/sort'], 'post', ['enctype' => 'multipart/form-data']); ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '5%'],
                ],

                [
                    // 'headerOptions' => ['width' => '20%'],
                    'attribute' => 'title',
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
                    'class' => UniqueToggleColumn::class,
                    'contentOptions' => ['style' => 'text-align: center'],
                    'attribute' => 'is_right',
                    'action' => 'toggle-right',
                    'set' => 'main',
                    'filter' => [
                        Answer::STATE_RIGHT => Module::t('common', 'STATE_RIGHT'),
                        Answer::STATE_WRONG => Module::t('common', 'STATE_WRONG'),
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
