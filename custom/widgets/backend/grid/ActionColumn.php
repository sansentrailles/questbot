<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $contentOptions = [
        'class' => 'action-column',
    ];

    public $url;

    public $template = '{update}&nbsp;&nbsp;&nbsp;{delete}';

    public $actions = [
        'update' => 'update',
        'delete' => 'delete',
        'view' => 'view',
    ];

    public function createUrl($action, $model, $key, $index)
    {
        if ($this->url instanceof Closure) {
            return \call_user_func($this->url, $action, $model, $key, $index);
        }
        $btnAction = $this->actions[$action] ?? $action;
        $params = \is_array($key) ? $key : ['id' => (string)$key];
        $params[0] = $this->controller ? $this->controller . '/' . $btnAction : $btnAction;
        return Url::toRoute($params);
    }
}
