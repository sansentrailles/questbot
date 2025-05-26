<?php

declare(strict_types=1);

namespace app\custom\traits\common\general;

use ReflectionClass;

trait ClassNameTrait
{
    public static function getName()
    {
        return (new ReflectionClass(static::class))->getShortName();
    }
}
