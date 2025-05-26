<?php declare(strict_types=1);

// @var $this \yii\web\View
// @var $content string

use app\custom\helpers\AppHelper;
use app\custom\widgets\frontend\meta\googlemap\GoogleMapApiKey;
use yii\helpers\Html;

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php // = GoogleMapApiKey::widget()?>
    <title><?php echo Html::encode($this->title); ?></title>
    <link rel="stylesheet" href="/css/<?php echo AppHelper::getManifestData('css.json', 'combined.css'); ?>">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,fetch" defer></script>
    <script src="/js/<?php echo AppHelper::getManifestData('webpack.json', 'app.js'); ?>" defer></script>
    <style>
        .before-load * {
            -webkit-transition: none !important;
            transition: none !important;
            animation-duration: 0s !important;
        }
    </style>
</head>

<body>
    <?php $this->beginBody(); ?>
        <?php echo $this->render('_header'); ?>
            <?php echo $content; ?>
        <?php echo $this->render('_footer'); ?>
    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
