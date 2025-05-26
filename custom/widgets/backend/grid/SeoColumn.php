<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;
use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Url;

class SeoColumn extends DataColumn
{
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
     * @var string
     */
    public $redirectUrl;

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

    public function createUrl($model, $key, $index, $keys = [])
    {
        if ($this->url instanceof Closure) {
            return \call_user_func($this->url, $model, $key, $index, $keys);
        }
        $redirectUrl = $this->redirectUrl ?: Yii::$app->request->url;
        $params = \is_array($key) ? $key : ['refId' => (string)$key, 'redirectUrl' => $redirectUrl];
        $params = array_merge($params, $keys);
        $params[0] = '/admin/seo/seo';
        return Url::toRoute($params);
    }

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
