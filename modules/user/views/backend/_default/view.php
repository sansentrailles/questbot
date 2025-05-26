<?php declare(strict_types=1);

use app\modules\user\Module;
use yii\helpers\Html;
use yii\widgets\DetailView;

// @var $this yii\web\View
// @var $model \app\modules\user\models\backend\User

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Module::t('common', 'ADMIN_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-user',
    'text' => $this->title,
];
?>
<div class="user-view">
    <p>
        <?php echo Html::a(Module::t('common', 'BUTTON_UPDATE'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Module::t('common', 'BUTTON_DELETE'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('common', 'CONFIRM_DELETE'),
                'method' => 'post',
            ],
        ]); ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'firstname',
            'lastname',
            'email:email',
            'phone',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'status',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute' => 'role',
                'value' => ($role = Yii::$app->authManager->getRole($model->role)) ? $role->description : $model->role,
            ],
        ],
    ]); ?>

</div>
