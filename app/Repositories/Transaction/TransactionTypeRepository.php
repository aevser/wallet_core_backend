<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\TransactionType;

class TransactionTypeRepository
{
    public function __construct(private TransactionType $transaction_type_repository){}

    public function findByType(string $type): int
    {
        return $this->transaction_type_repository->query()->where('type', $type)->value('id');
    }
}
