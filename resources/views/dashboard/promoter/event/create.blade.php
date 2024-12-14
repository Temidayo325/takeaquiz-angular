@extends('layouts.admin')

@section('title', 'Create a new event')

@section('content')
	<div class="text-purple-1000 px-4 md:px-10 pb-20" x-data='{user: JSON.parse(localStorage.getItem("user"))}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">Create your events here, make the details as exciting and simple as possble. And don't forget to add appropriate tags as they woud help users search and sort events appropriately.</p>
				<a href="/promoter/dashboard/events" class="px-4 py-3 mt-3 font-bold md:font-normal bg-red-1000 text-gray-200">View all my events</a>
			</div>
			<img src="{{asset('/images/create-ticket.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div>
			<h1 class="font-body font-bold text-md md:text-lg pt-5 pb-3 md:mt-10">Create an event</h1>
		</div>
		<x-event.create-event-form></x-eventbxe.create-event-form>
	</div>

@endsection

