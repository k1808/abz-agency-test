<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use App\services\DateTimeService;
use App\services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tinify\Tinify;

class AuthController extends Controller
{
    public function register(Request $request)
    {
//        if(!$request->token){
//            return response()->json([
//                "success"=> false,
//                "message"=> "Token missing."
//            ], 422);
//        }
//        $unusedToken = Token::where(['name'=>$request->token])->first();
//        if(!$unusedToken || DateTimeService::isExpired($unusedToken->created_at)) {
//            return response()->json([
//                "success"=> false,
//                "message"=> "The token expired."
//            ], 422);
//        }

        try {
            $data = $request->validate([
//                'name' => 'required|string|max:60|min:2',
//                'email' => 'required|string|email|max:255|unique:' . User::class,
//                'phone' => ['required','string','unique:' . User::class, 'regex:/^\+380\d{9}$/'],
//                'password' => ['required', 'min:2'],
//                'position_id'=>'required|numeric'
                'photo' => 'required|file|mimes:webp,jpeg,png|max:5120',
            ]);
           } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();
            dd($errors);
            if ((isset($errors['email']) && $errors['email'][0] === 'The email has already been taken.') || (isset($errors['phone']) && $errors['phone'][0] === 'The phone has already been taken.')) {
                return response()->json(['success' => false, 'message' => 'User with this phone or email already exist'], 409);
            }
            if (isset($errors['phone']) && $errors['phone'][0] === 'The phone field format is invalid.') {
                return response()->json(['success' => false, 'message' => 'User phone number, should start with code of Ukraine +380 and must be a real phone'], 422);
            }
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        $image = $data['photo'];
        $name = time() . $image->getClientOriginalName();
        Tinify::setKey(env('TINI_PNG'));
        $filePath = Storage::disk('public')->putFileAs('/images/', $image, $name);
        $optimized = fromFile($filePath)->resize(array(
            "method" => "fit",
            "width" => 70,
            "height" => 70
        ))->toFile($name);
        dd($optimized);
        $filePath = Storage::disk('public')->putFileAs('/images/', $image, $name);



        return '';
       return response()->json([
          "success" => true,
          "user_id" => UserService::register($request->token, $data),
          "message" => "New user successfully registered"
       ]);
    }
}
