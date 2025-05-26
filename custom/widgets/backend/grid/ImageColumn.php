<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;
use yii\grid\DataColumn;
use yii\helpers\Html;

class ImageColumn extends DataColumn
{
    use CreateUrlTrait;

    /**
     * @var callable
     */
    public $url;

    /**
     * @var callable
     */
    public $path;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $action = 'index';

    /**
     * @var bool
     */
    public $isLinked = false;

    /**
     * @var string
     */
    public $maxWidth = '100%';

    /**
     * @var string
     */
    public $maxHeight = '100%';

    /**
     * @var string
     */
    public $alt = '';

    /**
     * {@inheritdoc}
     */
    public $contentOptions = [
        'style' => 'text-align: center',
    ];

    /**
     * {@inheritdoc}
     */
    public $headerOptions = ['width' => '15%'];

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $path = $this->path instanceof Closure ? \call_user_func($this->path, $model, $this->attribute) : $model->{$this->attribute};
        $html = Html::img($path, [
            'class' => 'img-responsive',
            'style' => 'max-width: ' . $this->maxWidth . '; max-height: ' . $this->maxHeight . '; display: inline-block;',
            'alt' => $this->alt,
        ]);

        if ($this->isLinked) {
            $url = $this->createUrl($model, $key, $index);
            $html = Html::a($html, $url);
        }

        return $value === null ? $this->grid->emptyCell : $html;
    }
}
