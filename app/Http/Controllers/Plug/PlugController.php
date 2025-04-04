<?php

namespace App\Http\Controllers\Plug;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\Plug\CreatePlugRequest;
use  App\Models\Plug;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class PlugController extends Controller
{
    public function index()
    {
    	// $plugs = Plug::with('user')->where('status', 'Active')->latest()->orderBy('id')->cursorPaginate(12);
        $plugs = Plug::with('user')
                ->where('status', 'Active')
                ->orderByRaw('RAND()')
                ->limit(10)
                ->get();
        // $premiumPlugs = Plug::with('user')->where('status', 'Active')->where('isPremium', true)->latest()->get();
    	return view("plugs", [
    		'plugs' => $plugs,
            // 'premiumPlugs' => $premiumPlugs
    	]);
    }

    public function backToHome()
    {
        $plugs = Plug::where('status', 'Active')
                ->orderByRaw('RAND()')
                ->limit(10)
                ->get();
        return response()->json([
    		'error' => false,
    		'errorMessage' => 'Search results returned successfully',
    		'data' => $plugs
    	]);
    }

    public function paginateUsers(Request $request)
    {
    	$users = Plug::with('user')->where('status', 'Active')->latest()->orderBy('id')->cursorPaginate(10);
    	return response()->json($users);
    }

    public function search(Request $request)
    {
    	$users = Search::add(Plug::with('user')->where('status', 'Active'), ['service', 'service_summary', 'usp', 'address', 'tags', 'contact_email', 'contact_whatsapp'])
                        // ->add(\App\Models\User::class, ['name', 'nickname'])
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
        // $plug = Plug::with('user')->where('user_id', auth()->id())->first();
        $plug = \App\Models\User::with('plug')->where('id', auth()->id())->first();

        return view("dashboard.user.plug", [ 
            'plug' => $plug, 
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first() 
        ]);
    }

    public function showPlug($id)
    {
        $searchParameter = (int) $id;
        $plug = ( $searchParameter > 0 ) ? Plug::with('user')->where('status', 'Active')->where('id', $id)->first() : Plug::with('user')->where('slug', $id)->where('status', 'Active')->first();
        // $premiumPlugs = Plug::with('user')->where('status', 'Active')->where('isPremium', true)->latest()->get();
        return view("plug", [ 'plug' => $plug ]);
    }

    // public function showPlugByName($name)
    // {
    //     $plug = Plug::with('user')->where('slug', $name)->where('status', 'Active')->first();
    //     return view("plug", ['plug' => $plug ]);
    // }
}
