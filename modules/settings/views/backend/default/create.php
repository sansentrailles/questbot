<?php declare(strict_types=1);

use app\modules\settings\Module;

app\modules\settings\SettingsAsset::register($this);

// @var $this yii\web\View
// @var $model app\modules\settings\forms\backend\SettingForm
// @var $modelValue app\modules\settings\forms\backend\SettingValueForm

$this->title = Module::t('common', 'SETTING_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SETTINGS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-gear',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form_create', [
        'model' => $model,
        // 'template' => $template,
        // 'itemTemplate' => $itemTemplate,
        // 'valueModels' => $valueModels,
        'groups' => $groups,
    ]); ?>

</div>
