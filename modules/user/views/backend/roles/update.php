<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var app\modules\user\forms\backend\RoleForm $model */
$title = $model->role->name;
$this->title = Module::t('common', 'ROLE_UPDATE') . ': ' . StringHelper::truncate($title, 40);
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'ROLES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-user-secret',
    'text' => $this->title,
];
?>
<div class="update">
    <?php echo $this->render('_form', [
        'model' => $model,
        'permissions' => $permissions,
    ]); ?>
</div>
