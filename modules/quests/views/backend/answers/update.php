<?php declare(strict_types=1);

use app\modules\quests\Module;

// @var $this yii\web\View

$quest = $task->quest;

$this->title = Module::t('common', 'TASK_ANSWER_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUESTS'), 'url' => ['/admin/quests/quests']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TASKS').": ". $quest->title, 'url' => ['/admin/quests/tasks', 'questId' => $quest->id]];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TASK_ANSWERS'), 'url' => ['/admin/quests/tasks', 'taskId' => $task->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-cubes',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
