<?php declare(strict_types=1);

use yii\grid\GridView;
use yii\helpers\Html;

// @var $this yii\web\View
// @var $searchModel app\modules\seo\forms\backend\search\SeoSearch
// @var $dataProvider yii\data\ActiveDataProvider

$this->title = Yii::t('common', 'Seos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-index">

    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?php echo Html::a(Yii::t('common', 'Create Seo'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ref_id',
            'section',
            'title',
            'keywords',
            // 'description',
            // 'text:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
