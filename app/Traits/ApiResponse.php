<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function success(bool $success, ?string $message, mixed $data, int $code): JsonResponse
    {
        $response = ['success' => $success];

        if ($message) { $response['message'] = $message; }

        $response['data'] = $data;

        return response()->json($response, $code);
    }

    public function error(bool $success, mixed $error, int $code): JsonResponse
    {
        return response()->json(['success' => $success, 'error' => $error], $code);
    }
}
