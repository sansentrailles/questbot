<?php declare(strict_types=1);

use app\modules\user\Module;

// @var $this yii\web\View
// @var $model \app\modules\user\models\backend\User

$this->title = Module::t('common', 'TITLE_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'ADMIN_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-user-plus',
    'text' => $this->title,
];
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
