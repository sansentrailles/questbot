<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;

class RoleColumn extends DataColumn
{
    public $adminRole = 'admin';

    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $label = $value ? $this->getRoleLabel($value) : $value;
        $class = $value === $this->adminRole ? 'danger' : 'primary';
        $html = Html::tag('span', Html::encode($label), ['class' => 'label label-' . $class]);
        return $value === null ? $this->grid->emptyCell : $html;
    }

    /**
     * @param string $roleName
     * @return string
     */
    protected function getRoleLabel($roleName)
    {
        if ($role = Yii::$app->authManager->getRole($roleName)) {
            return $role->description;
        }
        return $roleName;
    }
}
