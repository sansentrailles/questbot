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
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <?php /*
        <!-- Open Graph -->
        <meta property="og:title" content="Статистика квеста — Городской Квест Бот">
        <meta property="og:description" content="Детальная статистика прохождения квеста пользователем.">
        <meta property="og:image" content="https://placehold.co/600x400/3b82f6/ffffff?text=Quest+Statistics">
        <meta property="og:url" content=" https://your-quest-bot-site.com/quest-statistics.html ">
        <meta property="og:type" content="website">
        */?>
        <!-- TailwindCSS CDN -->
        <script src="https://cdn.tailwindcss.com "></script>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.6s ease-out forwards;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 text-white min-h-screen p-6 transition-all duration-500">
        <?php /*class="bg-gradient text-white font-sans" */?>
        <?php $this->beginBody(); ?>
            <?php echo $content; ?>
            <!-- Footer -->
            <footer class="max-w-4xl mx-auto mt-12 pt-6 border-t border-white/10 text-center text-sm text-gray-400"> &copy; <?= date('Y', time()) ?> Городской Квест Бот.</footer>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
