<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class ShareEventController extends Controller
{
    public function getSharedEvent($eventSlug)
    {
        $backToString = preg_replace('/[^a-zA-Z0-9]/', ' ', strip_tags(trim($eventSlug)));

        $event = Search::add(\App\Models\Event::with('user','tickets'), ['name'])
					    ->beginWithWildcard()
					    ->endWithWildcard(true)
					    ->orderByRelevance()
					    ->search($backToString);
        return view('shared.shared-event', ['event' => $event]);
    }
}
