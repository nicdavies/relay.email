<?php

namespace App\Http\Controllers\Api\Auth;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $client = new Client();
            $ip = $request->server('SERVER_ADDR');

            $endpoint = sprintf(
                'http://%s',
                $ip
            );

            $oauthResponse = $client->post($endpoint . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('APP_CLIENT_ID'),
                    'client_secret' => env('APP_CLIENT_SECRET'),
                    'scope' => '',
                    'username' => $request->get('username'),
                    'password' => $request->get('password'),
                ],
            ]);

            $oauthBody = json_decode($oauthResponse->getBody()->getContents(), true);

            $meResponse = $client->get($endpoint . '/api/account', [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $oauthBody['access_token']),
                    'Content-Type' => 'application/json',
                    'Accept' => 'applications/json',
                ],
            ]);

            return $meResponse;
        } catch (ClientException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            return response()->json($body, 401);
        }
    }
}
