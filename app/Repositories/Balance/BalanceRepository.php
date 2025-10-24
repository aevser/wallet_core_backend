<?php

namespace App\Repositories\Balance;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BalanceRepository
{
    public function __construct(private Balance $balance) {}

    public function getBalance(User $user): ?float
    {
        $balance = $this->findBalanceByUserId($user);

        return $balance ? $balance->amount : 0.00;
    }

    public function deposit(User $user, float $amount): Balance
    {
        return DB::transaction(function () use ($user, $amount) {
            $balance = $this->findBalanceByUserId($user);

            if (!$balance) { return $this->create($user, $amount); }

            return $this->increaseAmount($balance, $amount);
        });
    }

    public function withdraw(User $user, float $amount): Balance
    {
        return DB::transaction(function () use ($user, $amount) {
            $balance = $this->findBalanceByUserId($user);

            return $this->decreaseAmount($balance, $amount);
        });
    }

    public function transfer(User $user_from, User $user_to, float $amount): array
    {
        return DB::transaction(function () use ($user_from, $user_to, $amount) {
            $from_balance = $this->findBalanceByUserId($user_from);

            $to_balance = $this->findBalanceByUserId($user_to);

            if (!$to_balance) { $to_balance = $this->create($user_to, 0); }

            $this->decreaseAmount($from_balance, $amount);

            $this->increaseAmount($to_balance, $amount);

            return ['from_balance' => $from_balance, 'to_balance' => $to_balance];
        });
    }

    private function findBalanceByUserId(User $user): ?Balance
    {
        return $this->balance->query()->where('user_id', $user->id)->first();
    }

    private function create(User $user, float $amount): Balance
    {
        return $this->balance->query()->create(['user_id' => $user->id, 'amount' => $amount]);
    }

    private function increaseAmount(Balance $balance, float $amount): Balance
    {
        $balance->amount += $amount;

        $balance->save();

        return $balance;
    }

    private function decreaseAmount(Balance $balance, float $amount): Balance
    {
        $balance->amount -= $amount;

        $balance->save();

        return $balance;
    }
}
