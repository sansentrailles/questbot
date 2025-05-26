<?php

declare(strict_types=1);

namespace app\custom\services\transaction;

use Yii;

class TransactionManager
{
    public function begin()
    {
        return new Transaction(Yii::$app->db->beginTransaction());
    }
}
