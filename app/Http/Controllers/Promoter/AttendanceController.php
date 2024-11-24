<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class AttendanceController extends Controller
{
    
    public function markUserAsPresent(\App\Http\Requests\Ticket\TicketAttendanceRequest $request)
    {
        $attendance = \App\Models\Attendance::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => $request->user_id,
        ]);
        $attendance = \App\Models\Attendance::with('user:id,nickname,email')
                        ->where('ticket_id', $request->ticket_id)
                        ->where('user_id', $request->user_id)
                        ->first();
        return response()->json([
            'error' => false,
            'errorMessage' => 'Attendance successfully marked',
            'user' => $attendance
        ]);
    }

    public function search(Request $request)
    { 
        // Get all the user ids on the attendance list
        $attendance = \App\Models\Attendance::where('ticket_id', $request->ticket_id)->pluck('user_id')->toArray();
        // Get all the users that have paid for the ticket AND are not on the attendance list
        $sale = \App\Models\Sale::with('user:id,nickname,email')->where('ticket_id', $request->ticket_id)->where('status', 'Success')->whereNotIn('user_id', $attendance)->get();
        // Return the closest search
        $users = $sale->filter(function($sale) use ($request){
            return str_contains(strtolower($sale->user->nickname), strtolower($request->nickname)) ?? str_contains(strtolower($sale->user->name), strtolower($request->nickname));
        });
        return response()->json([
            'error' => false,
            'errorMessage' => 'Search result returned',
            'users' => $users
        ]);
    }
}
