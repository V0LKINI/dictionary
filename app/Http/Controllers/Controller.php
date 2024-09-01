<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function success($data = null)
    {
        $response = ['success' => true];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return $response;
    }

    protected function error($message, $status = 500, $data = null)
    {
        if ($message instanceof \Exception) {
            $message = $message->getMessage();
        }

        if (Str::isJson($message)) {
            $message = json_decode($message);
        }

        $response = [
            'success' => false,
            'error' => [
                'message' => $message,
                'status' => $status
            ]
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if ($status == 0 || !is_int($status)) {
            $status = 500;
        }

        return response()->json($response)->setStatusCode($status);
    }
}
