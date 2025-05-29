<?php declare(strict_types=1);

use app\modules\quests\Module;

// @var $this yii\web\View

$this->title = Module::t('common', 'QUEST_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'QUESTS'), 'url' => ['/admin/quests/quests']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-cube',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
