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
				<div class="mt-8">
					<template x-if="upcoming_events.length <= 0">
						<div>
							<p class="leading-8 py-4 text-sm tracking-wider">You haven't had any event tickets yet, get tickets for upcoming events to see them here</p>
							<a href="/user/dashboard/events" class="block text-center bg-gray-950 text-gray-200 px-10 py-3">See all upcoming events</a>
						</div>
					</template>
					<template x-if="upcoming_events.length > 0">
						<ul>
							<template x-for="event in upcoming_events">
								<div>
									<template x-if="event.ticket.type == 'VIP'">
										<div class="px-4 bg-gray-950 py-6 pb-10 rounded w-64 mx-auto text-gray-300 mt-2 text-center shadow-md border border-gray-200 hover:shadow-3xl hover:border-gray-100 relative ">
											<div class="grid gap-4">
												<div>
													<p class="text-sm text-greyish" x-text="user.nickname + ' \'s'">Light's</p>
													<h2 class="font-bold text-4xl py-2 text-red-1000">VIP</h2>
													<p class="text-sm text-greyish">ticket</p>
												</div>
												<div>
													<p x-text="event.event.user.nickname" class="text-greyish">Name of the promoter</p>
													<p class="text-greyish">presents</p>
													<h2 class="text-5xl font-display text-red-1000 py-3" x-text="event.event.name">Name of the event</h2>
												</div>
												<div class="text-greyish">
													<p class="mt-4 text-sm" x-text="event.event.event_date">10th of August, 2024</p>
													<p>
														<span x-text="new Date(event.event.event_date).toDateString()"></span> @ 
														<span x-text="event.event.starting_time"></span>
													</p>
													<p class="mt-4 text-sm" x-text="event.event.location">Location: 31270 Rahul Roads Beckerview, KS 94569-2627</p>
													<p x-text="event.event.state">Lagos state</p>
												</div>
											</div>
											<div class="mt-10">
												<p>
													<span class="text-greyish">Price :</span> 
													<span class="font-bold text-2xl text-red-1000">&#8358; </span>
													<span class="font-bold text-2xl text-red-1000" x-text="new Intl.NumberFormat().format(event.ticket.price)"></span>
												</p>
											</div>
										</div>
									</template>
									<template x-if="event.ticket.type == 'Early bird'">
										<div class="bg-white text-purple-1000 px-4 py-8 pb-5 rounded w-64 text-gray-950 mt-2 text-center border border-gray-200 shadow-md hover:shadow-lg ">
											<div>
												<div class="border-b border-black">
													<h2 class="text-4xl tracking-wide font-display" x-text="event.event.name"></h2>
													<p class="text-sm font-bold py-2" x-text="event.event.starting_time + ' ,' + event.event.event_date"></p>
												</div>
												<div class="grid grid-cols-2 gap-6 text-left mt-5">
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Ticket owner</p>
														<p class="font-bold text-lg text-black" x-text="user.nickname">CruiseHq</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Promoter</p>
														<p class="font-bold text-lg text-black" x-text="event.event.user.nickname">CruiseHq</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Date</p>
														<p class="font-bold text-black" x-text="new Date(event.event.event_date).toDateString()"></p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Time</p>
														<p class="font-bold text-black" x-text="event.event.starting_time">4:00 PM</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Location</p>
														<p class="font-bold text-black" x-text="event.event.location"></p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">State</p>
														<p class="font-bold text-black" x-text="event.event.state"></p>
													</div>
												</div>
												<div class="mt-10">
													<p>
														<span class="text-greyish">Price : </span>
														<span class="font-bold text-xl">&#8358; </span>
														<span class="text-xl" x-text="new Intl.NumberFormat().format(event.ticket.price)"></span>
													</p>
												</div>
											</div>
										</div>
									</template>
									<template x-if="event.ticket.type == 'General admission'">
										<div>
											<div class="bg-purple-1000 pt-4 pb-10 w-64 mx-auto text-gray-300 mt-2 text-center">
												<p class="text-md text-greyish py-2 block bg-transparent" x-text="user.nickname">Light</p>
												<h2 class="font-bold text-xl py-3 text-purple-1000 block bg-greyish">General admission</h2>
												<div class="px-4 text-greyish">
													<h2 class="my-4 text-5xl font-display text-lightpurple" x-text="event.event.name">Name of the event</h2>
													<p class="mt-4 text-sm" x-text="event.event.event_date">10th of August, 2024</p>
													<p x-text="new Date(event.event.event_date).toDateString()">Sunday 10th of August, 2024 @ 4:00 PM</p>
													<p x-text="event.event.location">31270 Rahul Roads Beckerview, KS 94569-2627</p>
													<p x-text="event.event.state + ' '+ event.event.state">Lagos state</p>
													<p class="pb-4">Orginizer: <span x-text="event.event.user.nickname"></span></p>
												</div>
												<div class="mt-10">
														<p>
															<span class="text-gray-700">Price :</span> 
															<span class="font-bold text-2xl text-lightpurple">&#8358; </span>
															<span class="font-bold text-2xl text-lightpurple" x-text="new Intl.NumberFormat().format(event.ticket.price)"></span>
														</p>
													</div>
											</div>
										</div>	
									</template>
								</div>
							</template>
						</ul>
					</template>
				</div>
			</div>
		</section>
	</div>

@endsection

