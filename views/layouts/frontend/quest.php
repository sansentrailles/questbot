<?php

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo Html::encode($this->title); ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
    </head>

    <body class="bg-gradient text-white font-sans">
        <?php $this->beginBody(); ?>
            <div class="container"></div>
                <?php echo $content; ?>
                <footer class="max-w-4xl mx-auto mt-12 pt-6 border-t border-white/10 text-center text-sm text-gray-400"> &copy; <?= date('Y', time()) ?> Городской Квест Бот.</footer>
            </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
