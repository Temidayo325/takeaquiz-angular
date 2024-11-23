@extends('layouts.admin')

@section('title', 'Welcome to your homepage')

@section('content')
	<div class="text-black" x-data='{ user: @json($user),
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
   		}
	}'>
		<h1>Homepage dashboard</h1>
	</div>

@endsection

