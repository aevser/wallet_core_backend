<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Transaction;

class TransactionRepository
{
    public function __construct(private Transaction $transaction){}

    public function create(array $data): Transaction
    {
        return $this->transaction->query()->create($data);
    }
}
