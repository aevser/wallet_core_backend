<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\BalanceService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    use ApiResponse;

    public function __construct(
        private UserRepository $user_repository,
        private BalanceService  $balance_service
    ){}

    public function balance(int $user_id): JsonResponse
    {
        $user = $this->user_repository->findById($user_id);

        $balance = $this->balance_service->getBalance(user: $user);

        return $this->success(success: true, message: null, data: $balance['data'], code: JsonResponse::HTTP_OK);
    }
}
