@extends('layouts.user-dashboard')

@section('title', 'My dashboard')

@section('content')
	<div class="text-gray-950" x-data='{ user: @json($user),
		events: @json($events),
		upcoming_events: @json($upcoming_events),
		init() {
        	localStorage.setItem("user", JSON.stringify(this.user))
        	console.log(this.events)
   		}
	}'>
		<section class="grid gap-10">
			<div>
				<div class="flex justify-between items-center">
					<h2 class="font-bold text-lg">Upcoming ticket</h2>
					<a href="#" class="text-blue-700 underline underline-offset-2 cursor-pointer">View all</a>
				</div>
				<div>
					<template x-if="upcoming_events.length <= 0">
						<p class="leading-8 py-4 font-bold text-sm tracking-wider">You do not have an upcoming event yet, get tickets for upcoming events to see them here</p>
					</template>
					<template x-if="upcoming_events.length > 0">
						<ul>
							<template x-for="event in upcoming_events">
								<li>
									<p x-text="event.event.name"></p>
								</li>
							</template>
						</ul>
					</template>
				</div>
			</div>
			<div>
				<div class="flex justify-between items-center">
					<h2 class="font-bold text-lg">All events</h2>
					<a href="#" class="text-blue-700 underline underline-offset-2 cursor-pointer">View all</a>
				</div>
				<div>
					<template x-if="events.length <= 0">
						<p class="leading-8 py-4 font-bold text-sm tracking-wider">You haven't had any event tickets yet, get tickets for upcoming events to see them here</p>
					</template>
					<template x-if="events.length > 0">
						<ul>
							<template x-for="event in events">
								<li>
									<p x-text="event.name"></p>
								</li>
							</template>
						</ul>
					</template>
				</div>
			</div>
		</section>
	</div>

@endsection

