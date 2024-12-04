@extends('layouts.user-dashboard')

@section('title', 'My dashboard')

@section('content')
	<div class="text-purple-1000" x-data='{ user: @json($user),
		events: @json($events),
		upcoming_events: @json($upcoming_events),
		init() {
        	localStorage.setItem("user", JSON.stringify(this.user))
   		}
	}'>
		<section class="mt-2 grid gap-10">
			<div>
				<div class="flex justify-between items-center">
					<h2 class="font-bold font-body text-lg">My upcoming events</h2>
					<template x-if="events.length > 2">
						<a href="#" class="text-sm underline underline-offset-2 cursor-pointer">View all</a>
					</template>
				</div>
				<div>
					<template x-if="upcoming_events.length <= 0">
						<p class="leading-8 py-4 font-bold text-sm tracking-wider">You do not have an upcoming event yet, get tickets for upcoming events to see them here</p>
					</template>
					<template x-if="upcoming_events.length > 0">
						<ul class="w-full overflow-x-auto">
							<template x-for="event in upcoming_events">
								<li class="py-5">
									<div class="grid gap-2 md:flex md:justify-start md:items-start ">
										<p x-text="new Date().toDateString()" class=""></p>
										<img :src="`{{ asset('.') }}${event.event.flier}`" alt="Image depicting the game" class="w-full h-auto">
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
					<h2 class="font-bold font-body text-lg">My events</h2>
					<template x-if="events.length > 2">
						<a href="/user/dashboard/events" class="text-sm underline underline-offset-2 cursor-pointer">View all</a>
					</template>
				</div>
				<div class="py-10 ">
					<template x-if="events.length <= 0">
						<p class="leading-8 py-4 font-bold text-sm tracking-wider">You haven't had any event tickets yet, get tickets for upcoming events to see them here. Click <a href="/user/dashboard/events">here</a> to see available events around you</p>
					</template>
					<template x-if="events.length > 0">
						<ul class="grid gap-3">
							<template x-for="event in events">
								<li class="py-3 px-4 shadow-lg hover:shadow-2xl border border-gray-200">
									<div class="grid gap-2 md:flex md:justify-start md:items-start ">
										<p x-text="new Date().toDateString()" class=""></p>
										<img :src="`{{ asset('.') }}${event.event.flier}`" alt="Image depicting the game" class="w-full h-auto">
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
		</section>
	</div>

@endsection

