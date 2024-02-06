<?php

namespace App\services;

use App\Models\Token;
use App\Models\User;
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
        $user->save();

        $image = $data['photo'];
        $name = time() . $image->getClientOriginalName();
        Tinify\setKey(env('TINI_PNG'));
        $optimized = Tinify\fromFile($data['photo'])->resize(array(
            "method" => "fit",
            "width" => 70,
            "height" => 70
        ))->toFile($name);
        $filePath = Storage::disk('public')->putFileAs('/images/', $optimized, $name);
        $img = $user->image()->create([
            'path' => $filePath
        ]);
        return $user->id;
    }
}
