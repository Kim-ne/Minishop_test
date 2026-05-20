<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    protected function success(mixed $data = null, string $message = 'Success', int $code = 200): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::success($data,$message,$code);
    }

    protected function error(string $message = 'Error', int $code = 400, mixed $errors = null): \Illuminate\Http\JsonResponse
    {
        return ApiResponse::error($errors,$message,$code);
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
}
