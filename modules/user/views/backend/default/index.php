<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\LinkColumn;
use app\modules\user\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

// @var $this yii\web\View
// @var $searchModel app\modules\user\models\backend\search\UserSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'USERS');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['boxheader'] = [
    'icon' => 'fa-tag',
    'text' => $this->title,
];

?>
<div class="index">

    <p>
        <?php echo Html::a(Module::t('common', 'USER_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
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
                'class' => LinkColumn::className(),
                'attribute' => 'fullname',
                'action' => 'update',
            ],

            [
                'attribute' => 'email',
                'format' => 'raw',
                'value' => static function ($model) {
                    $link = Url::to(['/admin/user/default/update', 'id' => $model->id]);
                    $label = $model->email;
                    return Html::a($label, $link);
                },
            ],

            [
                'attribute' => 'phone',
                'format' => 'raw',
                'value' => static function ($model) {
                    $link = Url::to(['/admin/user/default/update', 'id' => $model->id]);
                    $label = $model->phone;
                    return Html::a($label, $link);
                },
            ],

            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['style' => 'text-align: center;'],
                'headerOptions' => ['width' => '5%'],
            ],
        ],
    ]); ?>
</div>
