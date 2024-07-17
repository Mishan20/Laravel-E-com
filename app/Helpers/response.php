<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'code' => 200,
            'message' => $message,
            'endpoint' => request()->path(),
            'data' => $result,
            'meta' => [
                'total' => is_countable($result) ? count($result) : 1,
                'request_time' => now()->toDateTimeString()
            ]
        ];

        return response()->json($response, 200);
    }

    /**
     * Error response method.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 500)
    {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $error,
            'endpoint' => request()->path(),
            'errors' => $errorMessages,
            'meta' => [
                'request_time' => now()->toDateTimeString()
            ]
        ];

        return response()->json($response, $code);
    }
}