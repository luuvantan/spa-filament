<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Response thành công
     */
    public static function success($data = null, string $message = 'Successfully', int $code = 200)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], 200); // HTTP 200 dù là 201, 204, ...
    }

    /**
     * Response lỗi chung
     */
    public static function error(string $message = 'Something went wrong', int $code = 500, $data = null)
    {
        return response()->json([
            'code'    => $code,     // App-level code
            'message' => $message,
            'data'    => $data,
        ], 200); // luôn trả HTTP 200 để frontend xử lý đơn giản
    }

    /**
     * Lỗi xác thực form
     */
    public static function validation($errors, string $message = 'Validation failed')
    {
        return self::error($message, 422, $errors);
    }

    /**
     * Không có quyền
     */
    public static function unauthorized(string $message = 'Unauthorized')
    {
        return self::error($message, 401);
    }

    /**
     * Không tìm thấy
     */
    public static function notFound(string $message = 'Not Found')
    {
        return self::error($message, 404);
    }

    /**
     * Phân trang
     */
    public static function paginated($paginator, string $message = 'Successfully')
    {
        return response()->json([
            'code'    => 200,
            'message' => $message,
            'data'    => $paginator->items(),
            'meta'    => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
            ],
        ], 200);
    }
}
