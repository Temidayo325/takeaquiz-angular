@extends('layouts.user-dashboard')

@section('title', 'All my tickets')

@section('content')
	<div class="text-gray-950" x-data='{ user: @json($user),
		events: @json($events),
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
        	console.log(this.events)
   		}
	}'>
		<section class="grid gap-10">
			<div>
				<div class="">
					<h2 class="font-bold text-lg">All events</h2>
				</div>
				<div>
					<template x-if="events.length <= 0">
						<div>
							<p class="leading-8 py-4 text-sm tracking-wider">You haven't had any event tickets yet, get tickets for upcoming events to see them here</p>
							<a href="/user/dashboard/events" class="block text-center bg-gray-950 text-gray-200 px-10 py-3">See all upcoming events</a>
						</div>
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

