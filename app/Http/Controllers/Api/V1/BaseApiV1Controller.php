<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ApiResponse;
use App\Http\Controllers\Api\BaseApiController;

class BaseApiV1Controller extends BaseApiController
{
    protected function success(mixed $data = null, string $message = 'Success', int $code = 200): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::success($data, $message, $code);
    }

    protected function error(?string $message = null, int|string $code = 400, mixed $errors = null): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::error($message, $code, $errors);
    }

    protected function created(mixed $data = null, string $message = 'Created successfully'): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::created($data,$message);
    }

    protected function notFound(string $message = 'Resource not found'): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::notFound($message);
    }

    protected function validationError(mixed $errors, string $message = 'Validation failed'): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::validationError($errors, $message);
    }

    protected function parseException(\Exception $e, string $fallBackMessage = 'An Error Occurred.', int $fallBackCode = 422): array
    {
        $message = ($e->getMessage() !== null && $e->getMessage() !== '')
                    ? $e->getMessage()
                    : $fallBackMessage;

        $code = (int) $e->getCode();
        $code = ($code >= 400 && $code <= 599) ? $code : $fallBackCode;

        return [$message, $code];
    }
}
