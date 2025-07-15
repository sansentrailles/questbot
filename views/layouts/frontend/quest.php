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
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com "></script>
    </head>

    <body class="bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 text-white min-h-screen p-4 md:p-6 transition-all duration-500">
        <?php $this->beginBody(); ?>
            <div class="max-w-7xl mx-auto space-y-6">
                <?php echo $content; ?>
                <footer class="max-w-4xl mx-auto mt-12 pt-6 border-t border-white/10 text-center text-sm text-gray-400"> &copy; <?= date('Y', time()) ?> Городской Квест Бот.</footer>
            </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
