<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\grid;

use Closure;

trait ShowCellContentTrait
{
    public function showContent($model, $key, $index, $keys = [])
    {
        if ($this->show instanceof Closure) {
            return \call_user_func($this->show, $model, $key, $index, $keys);
        }
        return true;
    }
}
