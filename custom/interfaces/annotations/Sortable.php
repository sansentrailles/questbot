<?php

declare(strict_types=1);

namespace app\custom\interfaces\annotations;

interface Sortable
{
    public function setOrder(int $order): void;
}
