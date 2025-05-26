<?php

declare(strict_types=1);

namespace app\custom\validators\fake;

use yii\base\Model;

class FakeModel extends Model
{
    private $fakeValues = [];

    public function __get($name)
    {
        if (isset($this->fakeValues[$name])) {
            return $this->fakeValues[$name];
        }

        return null;
    }

    public function __set($name, $value): void
    {
        $this->fakeValues[$name] = $value;
    }
}
