<?php declare(strict_types=1);

use yii\helpers\Html;

$btnParams = [
    'type' => 'button',
    'class' => 'btn btn-app',
    'data-url' => $url,
    'data-action' => 'delete',
];

$icon = Html::tag('i', null, [
    'class' => 'fa fa-remove',
]);

?>

<?php echo Html::tag('button', $icon . 'Удалить', $btnParams); ?>
