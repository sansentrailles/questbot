<?php

declare(strict_types=1);

namespace app\custom\services\transaction;

class Transaction
{
    private $transaction;

    public function __construct(\yii\db\Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function commit(): void
    {
        $this->transaction->commit();
    }

    public function rollback(): void
    {
        $this->transaction->rollBack();
    }
}
