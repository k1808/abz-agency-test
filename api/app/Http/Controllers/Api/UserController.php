<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
   public function all(Request $request)
   {
       $count = $request->input('count', 5);
       $offset = $request->input('offset');
       $page = $request->input('page');

       if ($offset !== null) {
           Paginator::currentPageResolver(function () use ($offset, $count) {
               return floor($offset / $count) + 1;
           });
       } elseif ($page !== null) {
           Paginator::currentPageResolver(function () use ($page) {
               return $page;
           });
       }

       $users = User::where(['is_ready'=>true])->paginate($count);

       $formattedUsers = $users->map(function ($user) {
           return [
               'id' => $user->id,
               'name' => $user->name,
               'email' => $user->email,
               'phone' => $user->phone,
               'position' => $user->position->name,
               'position_id' => $user->position_id,
               'registration_timestamp' => strtotime($user->created_at),
               'photo' => $user->photo
           ];
       });

       $response = [
           'success' => true,
           'page' => $users->currentPage(),
           'total_pages' => $users->lastPage(),
           'total_users' => $users->total(),
           'count' => $users->count(),
           'links' => [
               'next_link' => $users->nextPageUrl(),
               'prev_link' => $users->previousPageUrl(),
           ],
           'users' => $formattedUsers,
       ];

       return response()->json($response);

   }

    public function one($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['success' => false, 'message' => 'The user_id must be an integer.'], 400);
        }
        $user = User::where(['id'=>$id])->first();
        if (!$user){
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $response = [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'position' => $user->position->name,
                'position_id' => $user->position_id,
                'registration_timestamp' => strtotime($user->created_at),
                'photo' => $user->photo
            ],
        ];

        return response()->json($response);

    }
}
