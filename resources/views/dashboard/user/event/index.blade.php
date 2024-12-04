@extends('layouts.user-dashboard')

@section('title', 'My dashboard')

@section('content')
	<x-event.calender :events="$events" :events_today="$events_today" :premium_events="$premium_events"></x-event.calender>
@endsection

