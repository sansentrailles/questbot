<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use yii\grid\DataColumn;

class RelationColumn extends DataColumn
{
    /**
     * @var string
     */
    public $relation = 'user';

    /**
     * @var string
     */
    public $field = 'fullname';

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $model->{$this->relation} ? $model->{$this->relation}->{$this->field} : $this->getDataCellValue($model, $key, $index);
        return $value === null ? $this->grid->emptyCell : $value;
    }
}
