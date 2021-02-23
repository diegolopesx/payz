<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionsService
{
    /**
     * @param   Request  $request
     *
     * @return bool|JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authorize(Request $request)
    {
        $client       = new \GuzzleHttp\Client();
        $response     = $client->request('POST',
            'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6',
            [
                'body' => $request
            ]);
        $code         = $response->getStatusCode();
        $curlResponse = json_decode($response->getBody()->getContents());
        if ($curlResponse->message != 'Autorizado') {
            throw new \Error($curlResponse);
        }
        return response()->json($curlResponse, $code);
    }

}
