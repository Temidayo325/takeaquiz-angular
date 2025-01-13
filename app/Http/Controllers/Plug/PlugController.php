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
    			$plug = ( new \App\Actions\Plug\CreatePlug() )( $request );
    			var_dump($plug);
	    		// return Redirect::route('user.plug.edit');
    		} catch (\Exception $e) {
    			var_dump($e->getMessage());
    			// return back()->with('error', $e->getMessage());
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
    	$users = Search::add(Plug::where('status', 'Active'), ['service', 'service_summary', 'usp', 'address', 'tags'])
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
            'data' => $users
        ]);
    }

    public function showPlug($id)
    {
        $plug = Plug::with('user')->where('status', 'Active')->where('id', $id)->first();
         // $premiumPlugs = Plug::with('user')->where('status', 'Active')->where('isPremium', true)->latest()->get();
        return view("plug", [ 'plug' => $plug ]);
    }
}
