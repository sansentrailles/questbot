<?php declare(strict_types=1);
$clearPhone = '+7' . $city->phone_code . str_replace('-', '', $city->phone);
?>

<div class="header__phone" data-animation="up">
    <a href="tel:<?php echo $clearPhone; ?>" class="header__phone-number">Тел. { <?php echo $city->phone_code; ?> } <?php echo $city->phone; ?></a>
</div>

<?php if ($social) { ?>
    <div class="header__social">
        <div class="social">
            <?php foreach ($social as $item) { ?>
                <a href="<?php echo $item->link; ?>" data-animation="up" target="_blank" class="social__item social__item_<?php echo $item->selector; ?>"></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>