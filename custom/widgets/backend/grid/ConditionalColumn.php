<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ConditionalColumn extends DataColumn
{
    /**
     * @var callable
     */
    public $active;

    /**
     * Array of classes for different values.
     *
     * ```
     * [
     *     true => ['labelContent' => 'registered', 'labelClass' => 'success'],
     *     false => ['labelContent' => 'not registered', 'labelClass' => 'warning'],
     * ]
     * ```
     * @var array
     */
    public $conditions = [];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $condition = $this->active instanceof Closure ? \call_user_func($this->active, $model, $key, $index) : $this->active;
        $case = $this->conditions[$condition];
        $content = ArrayHelper::getValue($case, 'labelContent', '');
        $class = ArrayHelper::getValue($case, 'labelClass', 'default');
        return Html::tag('span', Html::encode($content), ['class' => 'label label-' . $class]);
    }
}
