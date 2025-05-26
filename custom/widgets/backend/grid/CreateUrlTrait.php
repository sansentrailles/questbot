<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;
use yii\helpers\Url;

trait CreateUrlTrait
{
    public function createUrl($model, $key, $index, $keys = [])
    {
        if ($this->url instanceof Closure) {
            return \call_user_func($this->url, $model, $key, $index, $keys);
        }
        $params = \is_array($key) ? $key : ['id' => (string)$key];
        $params = array_merge($params, $keys);
        $params[0] = $this->controller ? $this->controller . '/' . $this->action : $this->action;

        return Url::toRoute($params);
    }
}
