@extends('layouts.user-dashboard')

@section('title', 'Sign up as a plug')

@section('content')
	<div class="text-purple-1000 flex justify-between items-center mt-8 mb-3 md:px-11">
		<h1 class="font-normal font-display text-5xl">Update your plug information</h1>
	</div>
	<div class="py-12 md:px-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-plugs.create :user="$plug"></x-plugs.create>
                </div>
            </div>
        </div>
    </div>
@endsection


