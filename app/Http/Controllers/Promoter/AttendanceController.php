<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    
    public function markUserAsPresent(\App\Http\Requests\Ticket\TicketIdRequest $request)
    {
        $attendance = \App\Models\Attendance::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => auth()->id(),
            'present' => true
        ]);
        return response()->json([
            'error' => false,
            'errorMessage' => 'Attendance successfully marked',
            'events' => $attendance
        ]);
    }
}
