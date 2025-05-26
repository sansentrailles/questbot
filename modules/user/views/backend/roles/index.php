<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\modules\user\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

// @var $this yii\web\View
// @var $searchModel app\modules\user\forms\backend\search\RoleSearch
// @var $dataProvider yii\data\ArrayDataProvider

$this->title = Module::t('common', 'ROLES');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['boxheader'] = [
    'icon' => 'fa-user-secret',
    'text' => $this->title,
];

?>
<div class="index">

    <p>
        <?php echo Html::a(Module::t('common', 'ROLE_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '5%'],
            ],

            [
                'headerOptions' => ['width' => '20%'],
                'attribute' => 'name',
                'format' => 'raw',
                'value' => static function ($model) {
                    $link = Url::to(['/admin/user/roles/update', 'name' => $model->name]);
                    $label = $model->name;
                    return Html::a($label, $link);
                },
            ],

            [
                'attribute' => 'description',
            ],

            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['style' => 'text-align: center;'],
                'headerOptions' => ['width' => '5%'],
            ],
        ],
    ]); ?>
</div>
