<?php declare(strict_types=1);

// @var $this yii\web\View
// @var $model app\modules\guide\forms\backend\GuideChapterForm

$this->title = 'Справка';
$this->params['breadcrumbs'][] = ['label' => 'Содержание', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['boxheader'] = [
    'icon' => 'fa-question',
    'text' => $this->title,
];
?>

<div class="guide">

    <div class="row">
        <?php if (null === $id) { ?>
            <div class="col-md-9">
                <?php echo $this->render('_inner/contents', ['chapters' => $chapters, 'chapter' => null]); ?>
            </div>
        <?php } else { ?>
            <div class="col-md-9">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-info"></i>
                        <h3 class="box-title">Раздел: <?php echo $chapter->title; ?></h3>
                    </div>

                    <div class="box-body">
                        <?php echo $chapter->text; ?>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <?php echo $this->render('_inner/contents', ['chapters' => $chapters, 'chapter' => $chapter]); ?>
            </div>
        <?php } ?>
    </div>

</div>

<style>
.guide .img-responsive {
    margin: 20px auto;
    border: #cccccc 1px solid;
}
</style>
