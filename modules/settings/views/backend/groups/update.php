<?php declare(strict_types=1);

use app\modules\settings\Module;

// @var $this yii\web\View
// @var $model app\modules\setting\forms\backend\SettingGroup

$this->title = Module::t('common', 'SETTING_GROUP_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SETTINGS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-bars',
    'text' => $this->title,
];
?>

<div class="update">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>
