<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;
use yii\grid\DataColumn;
use yii\helpers\Html;

class LinkColumn extends DataColumn
{
    use CreateUrlTrait;

    /**
     * @var callable
     */
    public $url;

    /**
     * @var bool
     */
    public $targetBlank = false;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $action = 'view';

    /**
     * @var string
     */
    public $text;

    /**
     * {@inheritdoc}
     */
    public $format = 'raw';

    /**
     * @var callable
     */
    public $active = true;

    /**
     * Additional keys.
     *
     * ```
     * ['entityId' => 1]
     * ```
     *
     * @var array
     */
    public $keys = [];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $active = $this->active instanceof Closure ? \call_user_func($this->active, $model) : $this->active;
        $value = $this->getDataCellValue($model, $key, $index);
        $text = $this->text ? $this->grid->formatter->format($this->text, $this->format) : $this->grid->formatter->format($value, $this->format);

        $url = $this->createUrl($model, $key, $index, $this->keys);
        $options = $this->targetBlank ? ['target' => '_blank'] : [];
        return $active ? Html::a($text, $url, $options) : $this->grid->emptyCell;
    }
}
