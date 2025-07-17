<?php

use yii\helpers\Html;

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
    <body class="bg-gray-900 text-white min-h-screen flex items-center justify-center px-4">
        <?php $this->beginBody(); ?>
        <div class="max-w-xl w-full mx-auto text-center space-y-6">
            <?= $content?>
            <footer class="mt-8 pt-6 border-t border-gray-700 text-sm text-gray-400"> &copy; <?= date('Y', time()) ?> Городской Квест Бот. Все права защищены. </footer>
        </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
