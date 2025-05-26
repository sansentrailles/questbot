<?php

declare(strict_types=1);

namespace app\custom\services\export;

use yii\base\Model;

interface Export
{
    public function export(Model $model);
}
