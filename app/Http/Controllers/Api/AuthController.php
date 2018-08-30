<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use GuzzleHttp\Client;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $user =  User::firstOrNew(['email'=>$request->email]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $http = new Client();

        $response = $http->post('http://passport-api.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'TrYRdZexKlCqqTEd05T0rwRGoS5o7D8z81jc1XiC',
                'username' => $request->email,
                'password' =>  $request->password,
                'scope' => '',
            ],
        ]);

        return response(['auth'=>json_decode((string) $response->getBody(), true),'user'=>$user]);

    }
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response(['statuse'=>'error','message'=>'User notfound...']);
        }
        if(Hash::check($request->password,$user->password)){
            $http = new Client();

        $response = $http->post('http://passport-api.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'TrYRdZexKlCqqTEd05T0rwRGoS5o7D8z81jc1XiC',
                'username' => $request->email,
                'password' =>  $request->password,
                'scope' => '',
            ],
        ]);

        return response(['data'=>json_decode((string) $response->getBody(), true)]);

        }
    }
}
