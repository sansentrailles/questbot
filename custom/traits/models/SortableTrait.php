<?php

declare(strict_types=1);

namespace app\custom\traits\models;

trait SortableTrait
{
    public $localOrderAttribute = 'ord';

    public function setOrder(int $order): void
    {
        $orderAttribute = $this->orderAttribute ?? $this->localOrderAttribute;
        $this->{$orderAttribute} = $order;
    }
}
