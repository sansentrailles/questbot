<?php declare(strict_types=1);

use yii\helpers\Html;

// @var $socialLinks \app\modules\contacts\modesl\SocialLink[]
?>

<ul class="social">
    <?php foreach ($socialLinks as $item) { ?>
        <?php /* @var $item \app\modules\contacts\modesl\SocialLink */ ?>
        <li class="social__item">
            <a href="<?php echo $item->link; ?>" target="_blank" class="social__link" data-hover aria-label="<?php echo Html::encode($item->label); ?>"><?php echo $item->label; ?></a>
        </li>
    <?php } ?>
</ul>