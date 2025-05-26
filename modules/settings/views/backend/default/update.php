<?php declare(strict_types=1);

use app\modules\settings\Module;

app\modules\settings\SettingsAsset::register($this);

// @var $this yii\web\View
// @var $model app\modules\settings\forms\backend\SettingForm
// @var $settings app\modules\settings\models\Setting
// @var $groups app\modules\settings\models\SettingGroup[]
// @var $isDev bool

$this->title = Module::t('common', 'SETTING_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'SETTINGS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-gear',
    'text' => $this->title,
];
?>
<div class="update">

    <?php echo $this->render('_form_update', [
        'model'        => $model,
        'isDev' => $isDev,
        'setting' => $setting,
        'itemTemplate' => $itemTemplate,
        'valueModels'  => $valueModels,
        'groups'       => $groups,
    ]); ?>

</div>
