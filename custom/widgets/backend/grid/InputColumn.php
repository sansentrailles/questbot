<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;

class InputColumn extends DataColumn
{
    /**
     * @var string
     */
    public $type = 'text';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var bool
     */
    public $isArray = true;

    /**
     * {@inheritdoc}
     */
    public $format = 'raw';

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $text = $this->grid->formatter->format($value, $this->format);
        $name = $this->isArray ? $this->name . '[' . $model->id . ']' : $this->name;
        $attributeValue = $model->{$this->attribute};
        return $value === null ? $this->grid->emptyCell : Html::input($this->type, $name, $attributeValue, ['class' => 'form-control', 'style' => 'text-align: center;']);
    }
}
