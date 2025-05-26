<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\arrayField;

use yii\base\Widget;

/**
 * Widget generates a set of specified fields for an attribute.
 *
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class ArrayField extends Widget
{
    public $fields;
    public $buttonColumnSize = 1;
    public $model;
    public $attribute;
    public $buttonText = '';
    public $columnSize = 3;
    public $info;

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        $this->registerAsset();
        $options = [
            'buttonText' => $this->buttonText,
            'attribute' => $this->attribute,
            'info' => $this->info,
            'model' => $this->model,
            'fields' => $this->fields,
            'fieldsCount' => \count($this->fields),
            'columnSize' => $this->columnSize,
            'buttonColumnSize' => $this->buttonColumnSize,
        ];
        return $this->render('item', $options);
    }

    private function registerAsset(): void
    {
        ArrayFieldAsset::register($this->getView());
    }
}
