<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\LinkColumn;
use app\custom\widgets\backend\grid\RoleColumn;
use app\custom\widgets\backend\grid\SetColumn;
use app\modules\user\models\backend\User;
use app\modules\user\Module;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $searchModel \app\modules\user\forms\backend\search\UserSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'ADMIN_USERS');
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-users',
    'text' => $this->title,
];
?>
<div class="users-index">
    <p>
        <?php echo Html::a(Module::t('common', 'ADMIN_USERS_ADD'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '5%'],
            ],
            // 'id',
            /*
            [
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
                ]),
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filterOptions' => [
                    'style' => 'max-width: 180px',
                ],
            ],
            */
            [
                'class' => LinkColumn::className(),
                'attribute' => 'fullname',
            ],
            'email:email',
            'phone',
            [
                'class' => SetColumn::className(),
                'filter' => User::getStatusesArray(),
                'attribute' => 'status',
                'name' => 'statusName',
                'cssCLasses' => [
                    User::STATUS_ACTIVE => 'success',
                    User::STATUS_WAIT => 'warning',
                    User::STATUS_BLOCKED => 'default',
                ],
            ],
            [
                'class' => RoleColumn::className(),
                'filter' => false,
                // 'filter' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
                'attribute' => 'role',
            ],

            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
    ]); ?>

</div>
