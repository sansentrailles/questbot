<?php declare(strict_types=1);

use yii\helpers\Url;

?>

<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-navicon"></i>
        <h3 class="box-title">Содерждание</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul>
            <?php foreach ($chapters as $item) {
                ?>
                <li>
                    <a href="<?php echo Url::to(['/admin/guide/default/view', 'id' => $item->id]); ?>">
                        <?php if ($chapter && $chapter->id === $item->id) { ?>
                            <strong>
                                <span class="fa fa-angle-right"></span>
                                <?php echo $item->title; ?>
                            </strong>
                        <?php } else { ?>
                            <?php echo $item->title; ?>
                        <?php } ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
