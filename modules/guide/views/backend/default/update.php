<?php declare(strict_types=1);

use app\modules\guide\Module;

// @var $this yii\web\View

$this->title = Module::t('common', 'GUIDE_CHAPTER_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'GUIDE_CHAPTERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
