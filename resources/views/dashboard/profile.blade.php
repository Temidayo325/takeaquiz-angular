@extends('layouts.admin')

@section('title', 'Welcome to your homepage')

@section('content')
	<div class="text-purple-1000 flex justify-between items-center pt-10 mb-3 px-4 md:px-12">
		<h1 class="font-bold text-lg">Profile</h1>
	</div>
	<div class="py-4 px-4 md:px-12 font-body text-purple-1000 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0 space-y-6 grid gap-10">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.add-profile-picture')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-plugs.create :user="$user"></x-plugs.create>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection


