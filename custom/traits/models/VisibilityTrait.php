<?php

declare(strict_types=1);

namespace app\custom\traits\models;

trait VisibilityTrait
{
    public $localvisibleAttribute = 'is_visible';

    public function toggleVisible()
    {
        $visibleAttribute = $this->visibleAttribute ?? $this->localvisibleAttribute;
        return $this->{$visibleAttribute} = !$this->{$visibleAttribute};
    }
}
