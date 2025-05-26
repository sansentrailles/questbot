<?php declare(strict_types=1);

use app\modules\user\Module;

// @var $this yii\web\View
// @var $model app\modules\user\forms\backend\RoleForm

$this->title = Module::t('common', 'USER_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-user-sercret',
    'text' => $this->title,
];
?>
<div class="create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'permissions' => $permissions,
    ]); ?>

</div>
