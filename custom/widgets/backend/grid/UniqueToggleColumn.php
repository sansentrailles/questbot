<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UniqueToggleColumn extends DataColumn
{
    use CreateUrlTrait;
    use ShowCellContentTrait;

    public const STATUS_OFF = 0;
    public const STATUS_ON = 1;

    /**
     * Array of classes for different values.
     *
     * ```
     * [
     *     User::STATUS_ACTIVE => 'fa-check',
     *     User::STATUS_INACTIVE => 'fa-close',
     * ]
     * ```
     * @var array
     */
    public $cssClasses = [
        self::STATUS_ON => 'fa-check',
        self::STATUS_OFF => 'fa-close',
    ];

    public $cssColors = [
        self::STATUS_ON => '#008d4c',
        self::STATUS_OFF => '#dd4b39',
    ];

    /**
     * @var callable
     */
    public $show;

    /**
     * @var callable
     */
    public $url;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $action = 'toggle';

    /**
     * @var string
     */
    public $labelClass = 'fa';

    /**
     * @var string
     */
    public $fontSize = '20px';

    /**
     * @var string
     */
    public $btnBackgroundColor = '#eaeaea';

    /**
     * @var string
     */
    public $set = '';

    /**
     * {@inheritdoc}
     */
    public $contentOptions = [
        'style' => 'text-align: center',
    ];

    /**
     * {@inheritdoc}
     */
    public $headerOptions = ['width' => '7%'];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $this->registerToggleColumnAsset();
        $value = $this->getDataCellValue($model, $key, $index);
        $class = ArrayHelper::getValue($this->cssClasses, $value, self::STATUS_OFF);
        $color = ArrayHelper::getValue($this->cssColors, $value, self::STATUS_OFF);
        $url = $this->createUrl($model, $key, $index);
        $show = $this->showContent($model, $key, $index);

        $btnParams = [
            'type' => 'button',
            'class' => 'btn btn-block btn-flat btn-unique-toggle btn-sm',
            'style' => 'background-color: ' . $this->btnBackgroundColor,
            'data-label-class-name' => $this->labelClass,
            'data-active-state-class-name' => $this->cssClasses[self::STATUS_ON],
            'data-inactive-state-class-name' => $this->cssClasses[self::STATUS_OFF],
            'data-active-state-color' => $this->cssColors[self::STATUS_ON],
            'data-inactive-state-color' => $this->cssColors[self::STATUS_OFF],
            'data-set' => $this->set,
            'data-url' => $url,
        ];

        $icon = Html::tag('i', null, [
            'class' => $this->labelClass . ' ' . $class,
            'style' => 'font-size: ' . $this->fontSize . '; color: ' . $color,
        ]);
        $button = Html::tag('button', $icon, $btnParams);

        return $value === null || $show === false ? $this->grid->emptyCell : $button;
    }

    private function registerToggleColumnAsset(): void
    {
        UniqueToggleColumnAsset::register($this->grid->getView());
    }
}
