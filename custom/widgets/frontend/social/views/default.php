<?php declare(strict_types=1);

?>

<ul class="social">
    <?php foreach ($socialLinks as $item) { ?>
        <?php if (file_exists(__DIR__ . '/items/_' . $item->selector . '.php')) { ?>
            <li class="social__item">
                <a href="<?php echo $item->link; ?>" class="social__link" target="_blank">
                    <?php echo $this->render('items/_' . $item->selector, ['item' => $item]); ?>
                </a>
            </li>
        <?php } ?>
    <?php } ?>
</ul>
