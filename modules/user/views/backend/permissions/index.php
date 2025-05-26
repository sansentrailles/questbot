<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\modules\user\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

// @var $this yii\web\View
// @var $searchModel app\modules\user\models\backend\search\PermissionSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'PERMISSIONS');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['boxheader'] = [
    'icon' => 'fa-key',
    'text' => $this->title,
];

?>
<div class="index">

    <p>
        <?php echo Html::a(Module::t('common', 'PERMISSION_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
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
                'attribute' => 'name',
                'format' => 'raw',
                'value' => static function ($model) {
                    $link = Url::to(['/admin/user/permissions/update', 'name' => $model->name]);
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
