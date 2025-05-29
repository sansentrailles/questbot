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

<body>
    <?php $this->beginBody(); ?>
        <?php echo $content; ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
