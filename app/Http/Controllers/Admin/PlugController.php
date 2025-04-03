<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plug;

class PlugController extends Controller
{
    public function list()
    {
        $statistics = Plug::with('user')
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->get();
        $total_plugs = Plug::count();
        $suspended_plugs = Plug::with('user.suspensions')->where('status', 'Suspended')->get();

        $plugs = Plug::with('user')
                ->where('status', 'Active')
                ->orderByRaw('RAND()')
                ->limit(10)
                ->get();
            
        return view("dashboard.admin.plug.index", [
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(), 
            'stats' => $statistics,
            'total_plugs' => $total_plugs,
            'plugs' => $plugs,
            'suspended' => $suspended_plugs
        ]);
    }

    public function index()
    {
        $notification = \App\Models\Notification::with('user.plug')->where('role', 'plug')->where('status', false)->get();
        return view("dashboard.admin.plug.notification", [
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(), 
            'notification' => $notification]);
    }

    public function approve(Request $request)
    {
        $notification = \App\Models\Notification::find($request->notification_id);
        $plug_role = \App\Models\Role::query()->where("role", "plug")->first();
        $user = \App\Models\User::find($notification->user_id);
        $user->role()->attach($plug_role);

        $plug = \App\Models\Plug::query()->where('user_id', $notification->user_id)->first();
        $plug->status = 'Active';
        $plug->save();

        $notification->status = true;
        $notification->save();
        return response()->json([
            'error' => false,
            'message' => 'request approved succesfully'
        ]);
    }

    public function suspend(Request $request)
    {
        $plug = \App\Models\Plug::query()->where('id', $request->plug_id)->first();
        $plug->status = 'Suspended';
        $plug->save();

        $suspension = \App\Models\Suspension::create([
            'reason' => $request->reason,
            'user_id' => $request->user_id
        ]);
        // Send an Email to notify User of Suspension
        return response()->json([
            'error' => false,
            'message' => 'Plug account suspended'
        ]);
    }
}
