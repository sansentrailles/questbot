<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var app\modules\user\forms\backend\PermissionForm $model */
$title = $model->permission->name;
$this->title = Module::t('common', 'PERMISSION_UPDATE') . ': ' . StringHelper::truncate($title, 40);
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'PERMISSIONS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-key',
    'text' => $this->title,
];
?>
<div class="update">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>
