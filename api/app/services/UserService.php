<?php

namespace App\services;

use App\Models\Token;
use App\Models\User;
use Artwl\LaravelTinify\Facades\Tinify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public static function createToken($user){
        $token = $user->createToken('registred')->plainTextToken;
        $user->auth_token = $token;
        $user->save();
        Token::create(['name'=>$token]);
        return $token;
    }

    public static function register($token, $data){
        $user = User::where(['is_ready'=>false])->first();
        $user->is_ready = true;
        $user->auth_token = $token;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = Hash::make($data['password']);
        $user->position_id = $data['position_id'];


        $image = $data['photo'];
        $name = time() . $image->getClientOriginalName();
        $result = Tinify::fromFile($image);

        $optimized = $result->resize(array(
            "method" => "fit",
            "width" => 70,
            "height" => 70
        ))->toFile('storage/images/'.$name);
        $user->photo = 'images/'.$name;
        $user->save();
        return $user->id;
    }
}
