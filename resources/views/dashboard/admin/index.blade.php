@extends('layouts.admin')

@section('title', 'Welcome to Admin dashboard')

@section('content')
	<div class="text-black px-10" x-data='{ user: @json($user),
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
   		}
	}'>
		<h1>Admin Homepage dashboard</h1>
	</div>

@endsection

