@extends('layouts.user-dashboard')

@section('title', 'My dashboard')

@section('content')
	<div class="text-purple-1000" x-data='{ user: @json($user),
		events: @json($events),
		upcoming_events: @json($upcoming_events),
		init() {
        	localStorage.setItem("user", JSON.stringify(this.user))
        	console.log(this.events)
   		}
	}'>
		<section class="mt-2 grid gap-10 md:px-10">
			<div>
				<div class="hidden md:block py-6">
					<h1 class="font-body text-3xl font-light"><span x-text="user.nickname + '\'s' + ' dashboard'"></span></h1>
				</div>
				<div class="hidden md:flex py-10 bg-purple-300 items-center justify-between px-12">
					<div class="max-w-lg">
						<h1 class="font-body font-bold text-4xl font-normal">Welcome back <span x-text="user.nickname"></span></h1>
						<p class="text-md leading-7 my-4">Track events from your favorite promoters and get their tickets all in the same space !!! Also bring more life to that event you're attending by checking our games and having a time to remember at the events </p>
						<a href="/user/dashboard/events" class="bg-red-1000 text-white px-9 py-3">Get started</a>
					</div>
					<img src="{{asset('/images/chilling.svg')}}" alt="People chilling" class="w-96 h-52">
				</div>
				<div class="flex justify-between items-center md:mt-10">
					<h2 class="font-normal font-body text-lg">My upcoming events</h2>
					<template x-if="events.length > 2">
						<a href="#" class="text-sm underline underline-offset-2 cursor-pointer">View all</a>
					</template>
				</div>
				<div class="md:px-12">
					<template x-if="upcoming_events.length <= 0">
						<p class="leading-8 py-4 font-bold text-sm tracking-wider">You do not have an upcoming event yet, get tickets for upcoming events to see them here</p>
					</template>
					<template x-if="upcoming_events.length > 0">
						<ul class="w-full overflow-x-auto">
							<template x-for="event in upcoming_events">
								<li class="py-5">
									<div class="grid gap-2">
										<p x-text="new Date().toDateString()" class=""></p>
										<img :src="`{{ asset('.') }}${event.event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
										<div>
											<h2 x-text="event.event.name" class="text-2xl"></h2>
											<div class="flex justify-start items-center gap-5 mt-1">
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
													<span x-text="event.event.state"></span>
												</p>
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
													<span x-text="event.event.starting_time"></span>
												</p>
											</div>
										</div>
									</div>
								</li>
							</template>
						</ul>
					</template>
				</div>
			</div>
			<div>
				<div class="flex justify-between items-center">
					<h2 class="font-normal font-body text-lg">My events</h2>
					<template x-if="events.length > 2">
						<a href="/user/dashboard/events" class="text-sm underline underline-offset-2 cursor-pointer">View all</a>
					</template>
				</div>
				<div class="py-10 md:px-12">
					<template x-if="events.length <= 0">
						<p class="leading-8 py-4 font-bold text-sm tracking-wider">You haven't had any event tickets yet, get tickets for upcoming events to see them here. Click <a href="/user/dashboard/events">here</a> to see available events around you</p>
					</template>
					<template x-if="events.length > 0">
						<ul class="grid gap-3">
							<template x-for="event in events">
								<li class="py-3 px-4 shadow-lg md:shadow-sm hover:scale-105 hover:shadow-xl transition duration-900 ease-in-out border border-gray-200">
									<div class="grid gap-2 md:flex md:justify-start md:items-center md:gap-3">
										<p x-text="new Date(event.event_date).toDateString()" class="md:hidden"></p>
										<img :src="`{{ asset('.') }}${event.event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64">
										<div>
											<h2 x-text="event.event.name" class="text-2xl"></h2>
											<p x-text="new Date().toDateString()" class="hidden md:block my-2"></p>
											<div class="flex justify-start items-center gap-5 mt-1">
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">  <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" /></svg>
													<span x-text="event.event.state"></span>
												</p>
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
													<span x-text="event.event.starting_time"></span>
												</p>
											</div>
											<p class="hidden md:flex justify-start items-center gap-1 mt-2">
												<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
												<span x-text="event.event.location"></span>
											</p>
										</div>
									</div>
								</li>
							</template>
						</ul>
					</template>
				</div>
			</div>
		</section>
	</div>

@endsection

