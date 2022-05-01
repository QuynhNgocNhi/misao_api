<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Log;

class ApiController extends Controller {

    public function __construct()
    {
    }

    public function json($data, $message = 'success', int $statusCode = 200): JsonResponse
    {
        if (!is_array($data) && !is_object($data)) {
            $data = empty($data) ? [] : [$data];
        }

        $dataFormat = [
            'success' => $statusCode === 200 ? true : false,
            'message' => $message,
            'data' => empty($data) ? (object)[] : $data
        ];

        return response()->json($dataFormat, $statusCode);
    }

    static public function jsonResponse($data, $message = 'success', int $statusCode = 200): JsonResponse
    {
        if (!is_array($data) && !is_object($data)) {
            $data = empty($data) ? [] : [$data];
        }

        $dataFormat = [
            'success' => $statusCode === 200 ? true : false,
            'message' => $message,
            'data' => empty($data) ? (object)[] : $data
        ];

        return response()->json($dataFormat, $statusCode);
    }
}
