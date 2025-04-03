<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\Plug\CreatePlugRequest;
use App\Models\Plug;

class PlugController extends Controller
{
    public function index()
    {
        $notification = \App\Models\Notification::query()->where('role', 'plug')->where('user_id', auth()->id())->first();
        return view("dashboard.user.plug.create", [
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(), 
            'notification' => $notification
        ]);
    }

    public function store(CreatePlugRequest $request)
    {
    	try {
            $plug = Plug::where('user_id', auth()->id())->first();
            if ($plug == null) {
                $plug = ( new \App\Actions\Plug\CreatePlug() )( $request );
                $notification_exists = \App\Models\Notification::query()->where('role', 'plug')->where('user_id', auth()->id())->first();
                if($notification_exists != null)
                {
                    return response()->json([
                        'message' => 'You notification has been previously received and work is been done concerning it',
                        'error' => true
                    ]);
                }

                \App\Models\Notification::create([
                    'summary' => "Service provided: " .$request->service ."Service summary: ".$request->service_summary,
                    'user_id' => auth()->id(),
                    'role' => 'plug'
                ]); 
            }
            return redirect()
                    ->intended(route('user.plug.edit', absolute: false))
                    ->with('success', 'Plug form request succesfully completed');
                    
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    // public function create(\App\Http\Requests\Plug\RequestPlugAccessRequest $request)
    // {
    //     $notification_exists = \App\Models\Notification::query()->where('role', 'plug')->where('user_id', auth()->id())->first();
    //     if($notification_exists != null)
    //     {
    //         return response()->json([
    //             'message' => 'You notification has been previously received and work is been done concerning it',
    //             'error' => true
    //         ]);
    //     }

    //     \App\Models\Notification::create([
    //         'summary' => "Service provided: " .$request->service ."Service summary: ".$request->service_summary,
    //         'user_id' => auth()->id(),
    //         'role' => 'plug'
    //     ]); 

    //     return response()->json([
    //         'error' => false,
    //         'message' => 'notification succesfully created'
    //     ]);
    // }

    public function edit(CreatePlugRequest $request)
    {
    	try {
            $plug = Plug::where('user_id', auth()->id())->first();
            $plug->fill($request->validated());
            $plug->status = 'Inactive';
            $plug->tags = \App\Services\TurningStringToArray::convert( $request->tags );
            $plug->save();

            \App\Models\Notification::create([
                'summary' => "I made an update to my plug info, kindly verify and approve accordingly",
                'user_id' => auth()->id(),
                'role' => 'plug'
            ]); 
            
            return redirect()
                    ->intended(route('user.plug.edit', absolute: false))
                    ->with('success', 'Plug form request succesfully completed');
                    
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
