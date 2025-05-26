<?php declare(strict_types=1);
/**
 * @var \app\modules\contacts\modesl\SocialLink[] $socialLinks
 */
?>

<ul class="shared__list">
    <?php foreach ($socialLinks as $item) { ?>
        <li class="shared__item">
            <a href="<?php echo $item->link; ?>" target="_blank" class="shared__link" data-hover><?php echo $item->label; ?></a>
        </li>
    <?php } ?>
</ul>