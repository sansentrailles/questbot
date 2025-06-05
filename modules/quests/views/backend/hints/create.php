<?php declare(strict_types=1);

use app\modules\quests\Module;

// @var $this yii\web\View
// @var $model app\modules\quests\forms\backend\HintForm

$this->title = Module::t('common', 'HINT_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUESTS'), 'url' => ['/admin/quests/quests']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TASKS').": ". $task->quest->title, 'url' => ['/admin/quests/tasks', 'questId' => $task->quest_id]];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'HINTS'), 'url' => ['/admin/quests/hints', 'taskId' => $task->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-info',
    'text' => $this->title,
];
?>
<div class="create">

    <h4 class="text-blue">Подсказка для задания: <?= $task->question ?></h4>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
