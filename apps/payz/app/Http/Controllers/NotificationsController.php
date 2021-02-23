<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * @var string
     */
    private $sendMessageUrl;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sendMessageUrl
            = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';
        $this->middleware('auth');
    }

    public function push(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->sendMessageUrl, [
            'body' => $request
        ]);
        $code = $response->getStatusCode();
        $curlResponse = json_decode($response->getBody()->getContents());
        if ($curlResponse->message != 'Enviado') {
            throw new \Error($curlResponse->message);
        }
        return response()->json($curlResponse->message, $code);
    }
}
