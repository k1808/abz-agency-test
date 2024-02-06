<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        try {
            $positions = Position::all();
            if(count($positions)==0)  return response()->json(['success' => false, 'message' => "Positions not found"], 422);
            return response()->json([
                'success' => true,
                'positions' => $positions->map(function ($position) {
                    return [
                        'id' => $position->id,
                        'name' => $position->name,
                    ];
                }),
            ]);

        } catch (\ErrorException $e){
            return response()->json(['success' => false, 'message' => "Page not found"], 404);
        }
    }
}
