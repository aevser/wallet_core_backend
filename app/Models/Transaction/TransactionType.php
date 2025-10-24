<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionType extends Model
{
    protected $table = 'transaction_types';

    protected $fillable = ['name', 'type'];

    // Связи

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
