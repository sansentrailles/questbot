<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var app\modules\user\models\User $model */
$title = $model->user->email;
$this->title = Module::t('common', 'USER_UPDATE') . ': ' . StringHelper::truncate($title, 40);
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-account',
    'text' => $this->title,
];
?>
<div class="update">
    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]); ?>
</div>
