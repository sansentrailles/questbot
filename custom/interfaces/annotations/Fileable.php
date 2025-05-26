<?php

declare(strict_types=1);

namespace app\custom\interfaces\annotations;

interface Fileable
{
    public function getNestedFiles(): array;
}
