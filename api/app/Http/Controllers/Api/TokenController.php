<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use App\services\DateTimeService;
use App\services\UserService;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    public function index()
    {
        $user = User::where(['is_ready'=>false])->first();
        if(!$user) {
            $user = User::create([
                'name' => 'pet',
                'email' => 'example@i.tt',
                'password' => Hash::make('111'),
                'phone' => '888',
                'position_id' => 1
            ]);
            $token = UserService::createToken($user);
        } else {
            $unusedToken = Token::where(['name'=>$user->auth_token])->first();
            if($unusedToken==null) {
                $token = UserService::createToken($user);
            } else {
                if(DateTimeService::isExpired($unusedToken->created_at)){
                    $unusedToken->delete();
                    $token = UserService::createToken($user);
                } else {
                    $token = $user->auth_token;
                }
            }


        }

        return response()->json([
            "success"=> true,
            "token"=> $token
            ]);
    }
}
