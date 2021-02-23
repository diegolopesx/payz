<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    /**
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
