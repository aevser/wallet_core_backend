<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Repositories\Balance\BalanceRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionTypeRepository;

class BalanceService
{
    public function __construct(
        private BalanceRepository $balance_repository,
        private TransactionTypeRepository $transaction_type_repository,
        private TransactionRepository $transaction_repository
    ){}

    public function getBalance(User $user): array
    {
        $balance = $this->balance_repository->getBalance(user: $user);

        return [
            'success' => true,
            'data' => [
                'user_id' => $user->id,
                'balance' => $balance
            ]
        ];
    }

    public function deposit(User $user, float $amount, ?string $comment = null): array
    {
        $validation = $this->amountMustBePositive(amount: $amount);

        if (!empty($validation)) { return $validation; }

        $balance = $this->balance_repository->deposit(user: $user, amount: $amount);

        $type_id = $this->transaction_type_repository->findByType(type: TransactionType::DEPOSIT->value);

        $this->addTransaction(user_id: $user->id, type_id: $type_id, amount: $amount, comment: $comment);

        return [
            'success' => true,
            'data' => [
                'user_id' => $user->id,
                'balance' => $balance->amount,
                'comment' => $comment
            ]
        ];
    }

    public function withdraw(User $user, float $amount, ?string $comment = null): array
    {
        $validation = $this->amountMustBePositive($amount);

        if (!empty($validation)) { return $validation; }

        $current_balance = $this->balance_repository->getBalance(user: $user);

        $validation = $this->insufficientFunds(current_balance: $current_balance, amount: $amount);

        if (!empty($validation)) { return $validation; }

        $balance = $this->balance_repository->withdraw(user: $user, amount: $amount);

        $type_id = $this->transaction_type_repository->findByType(type: TransactionType::WITHDRAW->value);

        $this->addTransaction(user_id: $user->id, type_id: $type_id, amount: $amount, comment: $comment);

        return [
            'success' => true,
            'data' => [
                'user_id' => $user->id,
                'balance' => $balance->amount,
                'comment' => $comment
            ]
        ];
    }

    public function transfer(User $user_from, User $user_to, float $amount, ?string $comment = null): array
    {
        $validation = $this->amountMustBePositive($amount);

        if (!empty($validation)) { return $validation; }

        $validation = $this->cannotTransferToSelf(user_from: $user_from, user_to: $user_to);

        if (!empty($validation)) { return $validation; }

        $current_balance = $this->balance_repository->getBalance(user: $user_from);

        $validation = $this->insufficientFunds(current_balance: $current_balance, amount: $amount);

        if (!empty($validation)) { return $validation; }

        $result = $this->balance_repository->transfer(user_from: $user_from, user_to: $user_to, amount: $amount);

        $transfer_out_type_id = $this->transaction_type_repository->findByType(type: TransactionType::TRANSFER_OUT->value);
        $transfer_in_type_id = $this->transaction_type_repository->findByType(type: TransactionType::TRANSFER_IN->value);

        $this->addTransactionWithRelatedUser(user_id: $user_from->id, related_user_id: $user_to->id, type_id: $transfer_out_type_id, amount: $amount, comment: $comment);
        $this->addTransactionWithRelatedUser(user_id: $user_to->id, related_user_id: $user_from->id, type_id: $transfer_in_type_id, amount: $amount, comment: $comment);

        return [
            'success' => true,
            'data' => [
                'from_user_id' => $user_from->id,
                'from_balance' => $result['from_balance']->amount,
                'to_user_id' => $user_to->id,
                'to_balance' => $result['to_balance']->amount
            ]
        ];
    }

    private function addTransaction(int $user_id, int $type_id, float $amount, ?string $comment = null): Transaction
    {
        return $this->transaction_repository->create([
            'user_id' => $user_id,
            'type_id' => $type_id,
            'amount' => $amount,
            'comment' => $comment
        ]);
    }

    private function addTransactionWithRelatedUser(int $user_id, int $related_user_id, int $type_id, float $amount, ?string $comment = null): Transaction
    {
        return $this->transaction_repository->create([
            'user_id' => $user_id,
            'type_id' => $type_id,
            'amount' => $amount,
            'related_user_id' => $related_user_id,
            'comment' => $comment
        ]);
    }

    private function amountMustBePositive(float $amount): array
    {
        if ($amount <= 0) {
            return [
                'success' => false,
                'error' => [
                    'message' => __('responses.transaction.error.must_be_positive')
                ],
                'code' => 422
            ];
        }

        return [];
    }

    private function insufficientFunds(float $current_balance, float $amount): array
    {
        if ($current_balance < $amount) {
            return [
                'success' => false,
                'error' => [
                    'message' => __('responses.transaction.error.insufficient_funds')
                ],
                'code' => 409
            ];
        }

        return [];
    }

    private function cannotTransferToSelf(User $user_from, User $user_to): array
    {
        if ($user_from->id === $user_to->id) {
            return [
                'success' => false,
                'error' => [
                    'message' => __('responses.transaction.error.cannot_transfer_to_self')
                ],
                'code' => 422
            ];
        }

        return [];
    }
}
