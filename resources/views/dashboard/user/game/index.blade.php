@extends('layouts.user-dashboard')

@section('title', 'Checkout games for events')

@section('content')
	<x-games.all-games :games="$games"></x-games.all-games>
@endsection

