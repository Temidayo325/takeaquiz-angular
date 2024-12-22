@extends('layouts.admin')

@section('title', 'Welcome to your homepage')

@section('content')
	<div class="text-purple-1000 pt-5 px-4 md:px-10 pb:12" x-data='{ user: @json($user),
		events: @json($recent_events),
		chosenAttendance: [],
		chosenEvent: null,
		chosenEventTickets: null,
		typeLength: 0,
		upcoming_events: @json($upcoming_events),
		init() {
        	localStorage.setItem("user", JSON.stringify(this.user))
   		},
   		showEventDetail(event)
   		{
   			this.chosenEvent = event
   			this.chosenEventTickets = event.tickets
   			console.log(this.chosenEventTickets)
   			$refs.sideBarButton.dispatchEvent(new Event("click"))
   		}
	}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">Track your events realtime in terms of attendance and ticket sales</p>
				<a href="/user/dashboard/events" class="hidden md:block bg-red-1000 text-white text-center py-3 md:w-32">Get started</a>
			</div>
			<img src="{{asset('/images/admin-hero.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="flex justify-between items-center md:mt-10">
			<h2 class="font-body text-lg font-bold">My upcoming events</h2>
		</div>
		<div class="md:px-12">
			<template x-if="upcoming_events.length <= 0">
				<p class="leading-8 py-4 font-bold text-sm tracking-wider">You do not have an upcoming event yet, get tickets for upcoming events to see them here</p>
			</template>
			<template x-if="upcoming_events.length > 0">
				<ul class="w-full grid gap-6 mt-10 md:grid-cols-3 md:gap-x-10 md:gap-y-12">
					<template x-for="event in upcoming_events">
						<li class="p-3 bg-white shadow-lg md:shadow-sm cursor-pointer hover:shadow-2xl duration-700 border border-gray-200 hover:border-gray-400" @click="showEventDetail(event)">
							<div class="grid gap-2">
								<div class="flex justify-between items-center">
									<p x-text="new Date().toDateString(event.event_date)" class=""></p>
									<template x-if="event.isPremium == 1">
									    <span class="text-purple-1000 text-center text-2xl font-bold ">&#9824;</span>
									</template>
								</div>
								<img :src="`{{ asset('./images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
								<div>
									<h2 x-text="event.name" class="font-display tracking-wider text-xl"></h2>
									<div class="flex justify-start items-center gap-5 mt-1">
										<p class="flex justify-start items-center gap-1">
											<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
											<span x-text="event.state"></span>
										</p>
										<p class="flex justify-start items-center gap-1">
											<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
											<span x-text="event.starting_time"></span>
										</p>
									</div>
								</div>
							</div>
						</li>
					</template>
				</ul>
			</template>
		</div>
		<div class="flex justify-between items-center mt-10">
			<h2 class="font-bold font-body text-lg">My events</h2>
			<template x-if="events.length > 2">
				<a href="/promoter/dashboard/events" class="text-sm underline underline-offset-2 cursor-pointer">View all</a>
			</template>
		</div>
		<div class="py-3 md:py-10 md:px-12 text-purple-1000 pb:10">
			<template x-if="events.length <= 0">
				<p class="leading-8 py-2 md:py-4 font-bold text-sm tracking-wider">You haven't had any event tickets yet, get tickets for upcoming events to see them here. Click <a class="text-gray-100 bg-red-1000 px-3 py-1" href="#">here</a> to see available events around you</p>
			</template>
			<template x-if="events.length > 0">
				<ul class="grid gap-6 pb-12 md:grid-cols-3 md:gap-x-10 md:gap-y-12">
					<template x-for="event in events">
						<li class="hover:shadow-2xl duration-700 border border-gray-200 hover:border-gray-400 p-3 bg-white shadow-2xl md:shadow-sm cursor-pointer" @click="showEventDetail(event)">
							<div class="grid gap-2">
								<div class="flex justify-between items-center">
									<p x-text="new Date().toDateString(event.event_date)" class=""></p>
									<template x-if="event.isPremium == 1">
									    <span class="text-purple-1000 text-center text-2xl font-bold ">&#9824;</span>
									</template>
								</div>
								<img :src="`{{ asset('./images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
								<div>
									<h2 x-text="event.name" class="text-xl font-display tracking-wider"></h2>
									<div class="flex justify-start items-center gap-5 mt-1">
										<p class="flex justify-start items-center gap-1">
											<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
											<span x-text="event.state"></span>
										</p>
										<p class="flex justify-start items-center gap-1">
											<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
											<span x-text="event.starting_time"></span>
										</p>
									</div>
								</div>
							</div>
						</li>
					</template>
				</ul>
			</template>
		</div>

		<x-sidebar-toggle-button></x-sidebar-toggle-button>

	      <!-- drawer component -->
	    <div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
	        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
	            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
	            <span class="sr-only">Close menu</span>
	        </button>
	        <div class="py-4 overflow-y-auto text-black">

			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
			    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
			        <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Event</button>
			        </li>
			       {{--  <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Edit</button>
			        </li> --}}
			        <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-styled-tab" data-tabs-target="#styled-settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Tickets</button>
			        </li>
			    </ul>
			</div>
			<div id="default-styled-tab-content">
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
            		<template x-if="chosenEvent != null">
            			<div class="p-3 bg-white text-purple-1000 ">
							<div class="grid gap-2">
								<div class="flex justify-between items-center">
									<p x-text="new Date().toDateString(chosenEvent.event_date)" class=""></p>
									<template x-if="chosenEvent.isPremium == 1">
									    <span class="text-purple-1000 text-center text-2xl font-bold ">&#9824;</span>
									</template>
								</div>
								<img :src="`{{ asset('./images') }}/${chosenEvent.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
								<div>
									<h2 x-text="chosenEvent.name" class="text-xl font-display tracking-wider"></h2>
									<div class="flex justify-start items-center gap-5 mt-1">
										<p class="flex justify-start items-center gap-1">
											<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" /></svg>

											<span x-text="chosenEvent.state"></span>
										</p>
										<p class="flex justify-start items-center gap-1">
											<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
											<span x-text="chosenEvent.starting_time"></span>
										</p>
									</div>
									<p class="mt-2">
										<svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
										<span x-text="chosenEvent.location" class="text-sm inline ml-0"></span>
									</p>
								</div>
							</div>
						</div>
            		</template>	
			    </div>
			    {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
			        Ticket form would be here
			    </div> --}}
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 grid gap-10" id="styled-settings" role="tabpanel" aria-labelledby="settings-tab">
			       	<template x-if="chosenEventTickets != null && chosenEventTickets.length > 0">
			       		<template x-for="ticket in chosenEventTickets">
			       			<div>
			       				<template x-if="ticket.type.length == 10">
			            			<div >
										<div class="bg-white text-purple-1000 px-4 py-8 pb-5 rounded w-48 md:w-64 text-gray-950 mt-6 text-center border border-gray-200 shadow-md hover:shadow-lg ">
											<div class="border-b border-black">
												<h2 class="text-4xl tracking-wide font-display" x-text="chosenEvent.name"></h2>
												<p class="text-sm font-bold py-2" x-text="chosenEvent.starting_time + ' ,' + chosenEvent.event_date"></p>
											</div>
											<div class="grid grid-cols-2 gap-6 text-left mt-5">
												<div class="pb-3 border-b border-gray-300">
													<p class="text-greyish text-sm">Ticket owner</p>
													<p class="font-bold text-sm md:text-lg " x-text="user.nickname">CruiseHq</p>
												</div>
												<div class="pb-3 border-b border-gray-300">
													<p class="text-greyish text-sm">Organizer</p>
													<p class="font-bold text-sm md:text-lg" x-text="user.nickname">CruiseHq</p>
												</div>
												<div class="pb-3 border-b border-gray-300">
													<p class="text-greyish text-sm">Date</p>
													<p class="font-bold text-sm" x-text="new Date(chosenEvent.event_date).toDateString()"></p>
												</div>
												<div class="pb-3 border-b border-gray-300">
													<p class="text-greyish text-sm">Time</p>
													<p class="font-bold text-sm" x-text="chosenEvent.starting_time">4:00 PM</p>
												</div>
												<div class="pb-3 border-b border-gray-300">
													<p class="text-greyish text-sm">Location</p>
													<p class="font-bold text-sm" x-text="chosenEvent.location"></p>
												</div>
												<div class="pb-3 border-b border-gray-300">
													<p class="text-greyish text-sm">State</p>
													<p class="font-bold text-sm" x-text="chosenEvent.state"></p>
												</div>
											</div>
											<div class="mt-10 font-body">
												<p>
													<span class="text-greyish">Price : </span>
													<span class="font-bold text-xl">&#8358; </span>
													<span class="text-xl font-bold " x-text="new Intl.NumberFormat().format(ticket.price)"></span>
												</p>
											</div>
										</div>
										<div class="mt-6 md:mt-10 text-purple-1000">
											<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
										</div>
									</div>
			            		</template>		
			            		<template x-if="ticket.type.length >= 16">
			            			<div>
										<div class="bg-purple-1000 pt-4 pb-10 w-48 md:w-64 mx-auto text-gray-300 mt-6 text-center">
											<p class="text-md text-greyish py-2 block bg-transparent" x-text="user.nickname">Light</p>
											<h2 class="font-bold text-xl py-3 text-purple-1000 block bg-greyish">General admission</h2>
											<div class="px-4 text-greyish">
												<h2 class="my-4 text-4xl md:text-5xl font-display text-lightpurple" x-text="chosenEvent.name"></h2>
												<p class="mt-4 text-sm" x-text="chosenEvent.event_date"></p>
												<p x-text="new Date(chosenEvent.event_date).toDateString()"></p>
												<p x-text="chosenEvent.location"></p>
												<p x-text="chosenEvent.state "></p>
												<p class="pb-4">Orginizer: <span x-text="user.nickname"></span></p>
											</div>
											<div class="mt-10">
												<p>
													<span class="text-gray-700">Price :</span> 
													<span class="font-bold text-2xl text-lightpurple">&#8358; </span>
													<span class="font-bold text-2xl text-lightpurple" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
												</p>
											</div>
										</div>
										<div class="mt-6 md:mt-10 text-purple-1000">
											<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
										</div>
									</div>
			            		</template>
			            		<template x-if="ticket.type.length >= 3">
			            			<div>
			            				<div class="px-4 bg-gray-950 py-6 pb-10 rounded w-48 md:w-64 mx-auto text-gray-300 mt-6 text-center shadow-md border border-gray-200 hover:shadow-3xl hover:border-gray-100 relative ">
										<div class="grid gap-4">
											<div>
												<p class="text-sm text-greyish" x-text="user.nickname + ' \'s'">Light's</p>
												<h2 class="font-bold text-4xl py-2 text-red-1000">VIP</h2>
												<p class="text-sm text-greyish">ticket</p>
											</div>
											<div>
												<p x-text="user.nickname" class="text-greyish"></p>
												<p class="text-greyish">presents</p>
												<h2 class="text-4xl md:text-5xl font-display text-red-1000 py-3" x-text="chosenEvent.name"></h2>
											</div>
											<div class="text-greyish">
												<p class="mt-4 text-sm" x-text="chosenEvent.event_date"></p>
												<p>
													<span x-text="new Date(chosenEvent.event_date).toDateString()"></span> @ 
													<span x-text="chosenEvent.starting_time"></span>
												</p>
												<p class="mt-4 text-sm" x-text="chosenEvent.location"></p>
												<p x-text="chosenEvent.state"></p>
											</div>
										</div>
										<div class="mt-10">
											<p>
												<span class="text-greyish">Price :</span> 
												<span class="font-bold text-2xl text-red-1000">&#8358; </span>
												<span class="font-bold text-2xl text-red-1000" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
											</p>
										</div>
									</div>
									<div class="mt-6 md:mt-10 text-purple-1000">
										<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
										<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
									</div>
			            			</div>
			            		</template>	
			       			</div>
			       		</template>
			       	</template>
			       	<template x-if="chosenEventTickets != null && chosenEventTickets.length <= 0">
			       		<p>You have not created tickets for this event yet, go to the <a href="/promoter/dashboard/events" class="text-red-1000 py-2 px-2 font-bold">Events page</a> to create tickets for this event</p>
			       	</template>
			    </div>
			</div>
	        </div>
	    </div>
	</div>

@endsection

