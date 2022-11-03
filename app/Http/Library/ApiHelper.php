<?php

namespace App\Http\Library;

use Illuminate\Http\JsonResponse;

trait ApiHelper 
{
    protected function onSuccess(int $code, $data, string $message = ''): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function onError(int $code, array $errors = [], string $message = ''): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
