@extends('layouts.user-dashboard')

@section('title', 'My upcoming tickets')

@section('content')
	<div class="text-gray-950" x-data='{ user: @json($user),
		upcoming_events: @json($upcoming_events),
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
        	console.log(this.upcoming_events)
   		}
	}'>
		<section class="grid gap-10">
			<div>
				<div class="">
					<h2 class="font-bold text-lg">My Upcoming tickets</h2>
				</div>
				<div>
					<template x-if="upcoming_events.length <= 0">
						<div>
							<p class="leading-8 py-4 text-sm tracking-wider">You do not have an upcoming event yet, get tickets for upcoming events to see them here</p>
							<a href="/user/dashboard/events" class="block text-center bg-gray-950 text-gray-200 px-10 py-3">See all upcoming events</a>
						</div>	
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
		</section>
	</div>

@endsection

