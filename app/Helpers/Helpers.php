<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class Helpers
{
    public static function getAccountFromToken()
    {
        $token = JWTAuth::getToken();
        if (!empty($token)) {
            return JWTAuth::toUser($token);
        }
        return null;
    }

    /**
     * @param $data
     * @param $messages
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function _responseSuccess($data = null, $messages, $code = Response::HTTP_OK)
    {
        if (!empty($data)) {
            return response()->json([
                'status' => $code,
                'message' => $messages,
                'data' => $data
            ]);
        }

        return response()->json([
            'status' => $code,
            'message' => $messages,
        ]);
    }

    public static function _errors($messages, $code = Response::HTTP_FAILED_DEPENDENCY)
    {
        return self::_responseSuccess(null, $messages, $code);
    }
}
