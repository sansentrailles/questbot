<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\LinkColumn;
use app\modules\settings\Module;
use yii\grid\GridView;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $searchModel app\modules\settings\models\SettingGroup
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'SETTING_GROUPS');
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-bars',
    'text' => $this->title,
];

?>

<div class="index">
    <p>
        <?php echo Html::a(Module::t('common', 'SETTING_GROUP_CREATE'), ['create'], ['class' => 'btn btn-success']); ?>
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
                'attribute' => 'title',
                'class' => LinkColumn::class,
                'action' => 'update',
            ],

            'name',

            [
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
                'headerOptions' => ['width' => '5%'],
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
