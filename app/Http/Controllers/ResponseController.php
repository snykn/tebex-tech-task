<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ResponseController extends Controller
{
    /**
     * Success response function.
     *
     * @param string $message
     * @param $result
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(string $message, $result = [], int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
            'code'    => $code,
        ];

        return response()->json($response, $code);
    }

    /**
     * Error response function.
     *
     * @param string $message
     * @param $result
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(string $message, $result = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'code'    => $code,
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }
}
