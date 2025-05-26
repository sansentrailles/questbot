<?php declare(strict_types=1);

use app\custom\widgets\backend\grid\ActionColumn;
use app\custom\widgets\backend\grid\LinkColumn;
use app\modules\settings\models\Setting;
use app\modules\settings\Module;
use yii\grid\GridView;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $searchModel app\modules\settings\models\GalleryPhotoSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Module::t('common', 'SETTINGS');
// $this->params['breadcrumbs'][] = ['label' => Module::t('common', 'PAGE_MODULES')];
$this->params['breadcrumbs'][] = $this->title;

$this->params['boxheader'] = [
    'icon' => 'fa-gears',
    'text' => $this->title,
];

$isDev = Yii::$app->user->can('dev');

?>

<div class="settings-index">    
    <div class="btn-group">
        <button type="button" class="btn btn-success"><?php echo Module::t('common', 'SETTING_ADD'); ?></button>
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach (Setting::getVisibleTypes() as $typeId => $type) { ?>
                <li>
                    <?php echo Html::a($type['label'], ['create', 'typeId' => $typeId]); ?>
                </li>
            <?php } ?>
        </ul>
    </div>


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
                'value' => static function ($model) {
                    $html = '';
                    if ($model->desc) {
                        $html = " <span class='fa fa-question-circle' data-toggle='tooltip' data-placement='top' title='" . $model->desc . "'></span>";
                    }

                    return $model->title . $html;
                },
            ],

            [
                'attribute' => 'group_id',
                'value' => 'group.title',
                'filter' => $filterGroups,
            ],

            'key',

            [
                'attribute' => 'type_id',
                'format' => 'raw',
                'value' => static fn ($model) => Setting::getTypes()[$model->type_id]['label'],
                'filter' => Setting::getTypesForDropDown(),
            ],

            [
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'text-align: center;'],
                'headerOptions' => ['width' => '5%'],
                'template' => $isDev ? '{update} {delete}' : '{update}',
            ],
        ],
    ]); ?>
</div>
