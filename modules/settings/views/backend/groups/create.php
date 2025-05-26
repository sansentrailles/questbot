<?php declare(strict_types=1);

use app\modules\settings\Module;

// @var $this yii\web\View
// @var $model app\modules\settings\forms\backend\SettingGroupForm

$this->title = Module::t('common', 'SETTING_GROUP_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SETTINGS'), 'url' => ['index']];
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
