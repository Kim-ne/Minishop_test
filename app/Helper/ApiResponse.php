<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * return a standardized success response
     *
     * @param  mixed       $data    data return to client (object, array, string, etc.)
     * @param  string      $message Message to return to client
     * @param  int         $code    HTTP status code (default 200)
     */
    public static function success(
        mixed $data = null,
        string $message = 'Success',
        int $code = 200
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        // Only add 'data' if it's not null
        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * return a standardized error response
     *
     * @param  ?string     $message Message to return to client
     * @param  int|string  $code    HTTP status code (default 400)
     * @param  mixed       $errors  Error details (validation errors, etc.)
     */
    public static function error(
        ?string $message = null,
        int|string $code = 400,
        mixed $errors = null
    ): JsonResponse {
        $message = (isset($message) && $message !== '') ? $message : 'An Error Occurred.';

        $code =($code >= 400 && $code <= 599) ? $code : 400;

        $response = [
            'success' => false,
            'message' => $message,
        ];

        // Only add 'errors' if it's not null
        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Common response methods for specific scenarios
     */

    // 201 Created — resource created successfully
    public static function created(mixed $data = null, string $message = 'Created successfully'): JsonResponse
    {
        return self::success($data, $message, 201);
    }

    // 404 Not Found
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, 404);
    }

    // 401 Unauthorized — authentication required or failed
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, 401);
    }

    // 403 Forbidden — no permission
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, 403);
    }

    // 422 Unprocessable — validation failed
    public static function validationError(mixed $errors, string $message = 'Validation failed'): JsonResponse
    {
        return self::error($message, 422, $errors);
    }

    // 500 Server Error
    public static function serverError(string $message = 'Internal server error'): JsonResponse
    {
        return self::error($message, 500);
    }
}
