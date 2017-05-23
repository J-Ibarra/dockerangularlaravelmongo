<?php

namespace App\Http\Controllers;

use App\Libraries\Out;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
    public function userRegister(Request $request)
    { 
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:4|max:255|unique:users',
            'email' => 'required|email|min:4|max:255|unique:users',
            'password' => 'required|min:4|confirmed',
            'client_id' => 'required|exists:oauth_clients,_id',
            'client_secret' => 'required|exists:oauth_clients,secret',
        ]);

        if (!$validation->messages()->isEmpty()) {
            $data = $validation->messages()->toArray();
            return Out::json($data, 'user not stored.', false);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);


        return Out::json($user, 'user successfully stored.');
    }

    public function userToken(AuthorizationServer $server,
                              TokenRepository $tokens,
                              JwtParser $jwt,
                              ServerRequestInterface $serverRequest)
    {
        $accessToken = new AccessTokenController($server, $tokens, $jwt);
        $token = $accessToken->issueToken($serverRequest);
        if ($token->getReasonPhrase() == 'OK')
            return Out::json(json_decode($token->getBody(), true), 'getting token');
        else
            return Out::json(null, 'getting token failed', false);

    }

    public function user(Request $request)
    {
        return Out::json($request->user(), 'show user');
    }
}
