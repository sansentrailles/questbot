<?php declare(strict_types=1);

// @var $this \yii\web\View
// @var $content string

use yii\helpers\Html;

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo Html::encode($this->title); ?></title>
    <?= Html::csrfMetaTags() ?>

    <!-- Описание сайта -->
    <meta name="description" content="Платформа для увлекательных квестов, путешествий по городу и командных испытаний.">

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Open Graph / Facebook / Telegram мета-теги -->
    <meta property="og:title" content="Городской Квест Бот">
    <meta property="og:description" content="Платформа для увлекательных квестов, путешествий по городу и командных испытаний.">
    <meta property="og:image" content="https://quest.aroundcity.club/images/og2.png">
    <meta property="og:url" content="https://quest.aroundcity.club/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Городской Квест Бот">

    <!-- Twitter Card (дополнительно) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Городской Квест Бот">
    <meta name="twitter:description" content="Платформа для увлекательных квестов, путешествий по городу и командных испытаний.">
    <meta name="twitter:image" content="https://quest.aroundcity.club/images/og2.png">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <style>
        /* Добавляем анимацию появления */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 text-white min-h-screen flex items-center justify-center p-6 transition-all duration-500">
    <?php $this->beginBody(); ?>
        <?php echo $content; ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
