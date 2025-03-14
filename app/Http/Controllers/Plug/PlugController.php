<?php

namespace App\Http\Controllers\Plug;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\Plug\CreatePlugRequest;
use  App\Models\Plug;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class PlugController extends Controller
{
    public function store(CreatePlugRequest $request)
    {
    	try {
                $plug = Plug::where('user_id', auth()->id())->first();
                if ($plug == null) {
                    $plug = ( new \App\Actions\Plug\CreatePlug() )( $request );
                }
                return redirect()->intended(route('user.plug.edit', absolute: false));
    		} catch (\Exception $e) {
    			return back()->with('error', $e->getMessage());
    		}
    }

    public function index()
    {
    	$plugs = Plug::with('user')->where('status', 'Active')->latest()->orderBy('id')->cursorPaginate(12);
        // $premiumPlugs = Plug::with('user')->where('status', 'Active')->where('isPremium', true)->latest()->get();
    	return view("plugs", [
    		'plugs' => $plugs,
            // 'premiumPlugs' => $premiumPlugs
    	]);
    }

    public function paginateUsers(Request $request)
    {
    	$users = Plug::with('user')->where('status', 'Active')->latest()->orderBy('id')->cursorPaginate(10);
    	return response()->json($users);
    }

    public function search(Request $request)
    {
    	$users = Search::add(Plug::with('user')->where('status', 'Active'), ['service', 'service_summary', 'usp', 'address', 'tags'])
					    ->beginWithWildcard()
					    ->endWithWildcard(true)
					    ->orderByRelevance()
					    ->paginate(10)
					    ->search($request->searchTerm);

    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Search results returned successfully',
    		'data' => $users
    	]);
    }

    public function searchByTags(Request $request)
    {
        $plugs = Search::add(Plug::class, ['tags'])
                          ->beginWithWildcard() 
                          ->endWithWildcard(true)
                          ->orderByRelevance()
                          ->search($request->tag)
                          ->take(24);

        return response()->json([
            'error' => false,
            'message' => "plugs returned",
            'plugs' => [
                'data' => $plugs
            ]
        ]);
    }

    public function makePlugPremium(Request $request)
    {
        $plug = Plug::find($request->id);
        $plug->isPremium = ($plug->isPremium == false ) ? true : false;
        $plug->save();

        return response()->json([
            'error' => false,
            'errorMessage' => 'Premium feature enabled for plug',
            // 'data' => $user
        ]);
    }
    public function displayPlug()
    {
        $plug = Plug::with('user')->where('user_id', auth()->id())->first();
        return view("dashboard.user.plug", [ 
            'plug' => $plug, 
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first() 
        ]);
    }

    public function showPlug($id)
    {
        $searchParameter = (int) $id;
        $plug = ( $searchParameter > 0 ) ? Plug::with('user')->where('status', 'Active')->where('id', $id)->first() : Plug::with('user')->where('slug', $id)->where('status', 'Active')->first();
        $searchComponent = \Share::page(url()->current(), "Here's my plug card")
                            ->facebook()
                            ->twitter()
                            ->whatsapp()
                            ->linkedin();
        // $premiumPlugs = Plug::with('user')->where('status', 'Active')->where('isPremium', true)->latest()->get();
        return view("plug", [ 'plug' => $plug, 'shareButtons' => $searchComponent ]);
    }

    // public function showPlugByName($name)
    // {
    //     $plug = Plug::with('user')->where('slug', $name)->where('status', 'Active')->first();
    //     return view("plug", ['plug' => $plug ]);
    // }
}
