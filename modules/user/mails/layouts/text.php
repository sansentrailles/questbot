<?php declare(strict_types=1);
// @var $this \yii\web\View
// @var $content string
// @var $message \yii\mail\MessageInterface
// @var $content string
?>
<?php $this->beginPage(); ?>
<?php $this->beginBody(); ?>
<?php echo $content; ?>
<?php $this->endBody(); ?>
<?php $this->endPage(); ?>
