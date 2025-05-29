<?php declare(strict_types=1);

use app\modules\quests\Module;

// @var $this yii\web\View
// @var $model app\modules\quests\forms\backend\TaskForm

$this->title = Module::t('common', 'TASK_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUESTS'), 'url' => ['/admin/quests/quests']];
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'TASKS').": ". $quest->title, 'url' => ['/admin/quests/tasks', 'questId' => $quest->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-bars',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
