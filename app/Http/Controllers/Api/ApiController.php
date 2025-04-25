<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:takeaquizzes,email',
            'institution' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 422);
        }

        $user = \App\Models\Takeaquiz::query()->where('email', $request->email)->first();
        if($user != null)
        {
            return response()->json([
                'error' => false,
                'message' => 'Thank you for the signing up'
            ]);
        }
        $user = \App\Models\Takeaquiz::create([
            'name' => $request->name,
            'email' => $request->email,
            'institution' => $request->institution
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Thank you for the signing up'
        ]);
    }
}
