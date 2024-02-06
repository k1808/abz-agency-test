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

       $users = User::paginate($count);

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
           'users' => $users->items(),
       ];

       return response()->json($response);

   }
}
