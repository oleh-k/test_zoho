<?php

namespace App\Http\Controllers;

use App\Models\ZohoToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class ZohoTokensController extends Controller
{
    
    private $client_id = '1000.D64CQK4BEWB7AX7YIKRSB79FDGN6TP';
    private $client_secret = '1843a6b0bafb805c174d8eec9539c86224f6177cd3';
    private $redirect_uri = 'http://localhost:8000/api/grand_token';
    private $scope = 'ZohoCRM.modules.ALL';

    public function getRefreshToken(Request $request)
    {
        
        $code = $request->query('code');

        $arr = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'redirect_uri' => $this->redirect_uri,
            'scope' => $this->scope,
            'state' => 'test',
        ];

        $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', $arr);
        $object = $response->object();
        $refresh_token = $object->refresh_token;
        $access_token = $object->access_token;

        Redis::set('refresh_token', $refresh_token);
        Redis::set('access_token', $access_token);


    }

    public function getAccessToken(string $refreshToken = '')
    {

        $sessionRefreshToken = Redis::get('refresh_token');

        if ($refreshToken == '') {
            if ($sessionRefreshToken != '' && $sessionRefreshToken != null) $refreshToken = $sessionRefreshToken;
            else return response(['result' => 'empty refresh_token'], 401);
        }

        $arr = [
            'refresh_token' => $refreshToken,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => 'refresh_token',
        ];

        $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', $arr);

        $object = $response->object();

        $access_token = $object->access_token;

        Redis::set('access_token', $access_token);

        $result['access_token'] = $access_token;

        return response($result, 200);

    }

}
