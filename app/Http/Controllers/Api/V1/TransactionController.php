<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Api\Transaction\CreateDepositRequest;
use App\Http\Requests\V1\Api\Transaction\CreateTransferRequest;
use App\Http\Requests\V1\Api\Transaction\CreateWithdrawRequest;
use App\Repositories\UserRepository;
use App\Services\BalanceService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepository $user_repository, private BalanceService $balance_service){}

    public function deposit(CreateDepositRequest $request): JsonResponse
    {
        $user = $this->user_repository->findById(id: $request->user_id);

        $deposit = $this->balance_service->deposit(user: $user, amount: $request->amount, comment: $request->comment);

        if (!$deposit['success']) { return $this->error(success: false, error: $deposit['error'], code: $deposit['code']); }

        return $this->success(success: true, message: __('responses.transaction.success.deposit'), data: $deposit['data'], code: JsonResponse::HTTP_OK);
    }

    public function withdraw(CreateWithdrawRequest $request): JsonResponse
    {
        $user = $this->user_repository->findById(id: $request->user_id);

        $withdraw = $this->balance_service->withdraw(user: $user, amount: $request->amount, comment: $request->comment);

        if (!$withdraw['success']) { return $this->error(success: false, error: $withdraw['error'], code: $withdraw['code']); }

        return $this->success(success: true, message: __('responses.transaction.success.withdraw'), data: $withdraw['data'], code: JsonResponse::HTTP_OK);
    }

    public function transfer(CreateTransferRequest $request): JsonResponse
    {
        $user_from = $this->user_repository->findById(id: $request->from_user_id);

        $user_to = $this->user_repository->findById(id: $request->to_user_id);

        $transfer = $this->balance_service->transfer(user_from: $user_from, user_to: $user_to, amount: $request->amount, comment: $request->comment);

        if (!$transfer['success']) { return $this->error(success: false, error: $transfer['error'], code: $transfer['code']); }

        return $this->success(success: true, message: __('responses.transaction.success.transfer'), data: $transfer['data'], code: JsonResponse::HTTP_OK);
    }
}
