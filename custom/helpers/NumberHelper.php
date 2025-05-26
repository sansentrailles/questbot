<?php

declare(strict_types=1);

namespace app\custom\helpers;

class NumberHelper
{
    public static function addZero($number)
    {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }
}
