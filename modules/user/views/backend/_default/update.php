<?php declare(strict_types=1);

use app\modules\user\Module;

// @var $this yii\web\View
// @var $model \app\modules\user\models\backend\User

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'ADMIN_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('common', 'TITLE_UPDATE');
$this->params['boxheader'] = [
    'icon' => 'fa-user',
    'text' => $this->title,
];
?>
<div class="user-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
