@extends('layouts.user-dashboard')

@section('title', 'My dashboard')

@section('content')
	<div class="text-gray-950" x-data='{ user: @json($user),
		events: @json($events),
		premium_events: @json($premium_events),
		chosenEvents: [],
		chosenEvent: null,
		chosenTickets: [],
		start_date: new Date(),
		calender_days: [],
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
        	this.calender_days = this.getDates()
        	console.log(this.premium_events)
   		},
   		showTickets(events)
   		{
   			this.chosenEvents = events.events
   			console.log(events.events)
   			$refs.sideBarButton.dispatchEvent(new Event("click"))
   		},
   		getDates()
   		{
   			let days = []
   			let event_day = null
   			for (let i = 0; i <= 30; i++) {
			    const currentDate = new Date(this.start_date);
			    currentDate.setDate(this.start_date.getDate() + i);

			    event_day = this.events.filter( (event) => currentDate.getDate() == new Date(event.event_date).getDate())
			    days.push({day: currentDate.getDate(), events: event_day, hasEvents: (event_day.length > 0 ) ? true : false})
			}
			return days
   		},
   		showEventTickets(event, tickets)
   		{
   			this.chosenEvent = event
   			this.chosenTickets = tickets
   			$refs.viewEventTicket.dispatchEvent(new Event("click"))
   		},
   		initiateTicketPurchase(ticket_id)
   		{
   			try {
                axios.post("/user/dashboard/tickets/checkout", {ticket_id: ticket_id})
                .then(response => {
                	if( !response.data.error )
                	{
                		window.location.href = "/user/dashboard/ticket/checkout"
                	}
            	})
                .catch(error => console.log(error))
            } catch (error) {
                console.error(error)
            }
   		}
   		
	}'>
		<section class="text-gray-950">
			<div>
				<h2 class="font-bold text-lg">Premium events</h2>
				<div class="mt-2">
					<ul class="">
						<template x-if="premium_events.length <= 0">
							<li class="text-center py-1 text-gray-950">No premium events yet</li>
						</template>
						<template x-if="premium_events.length > 0">
							<template x-for="event in premium_events">
								<li>
									<img :src="`{{ asset('.') }}${event.flier}`" alt="Image depicting the game" class="w-full h-auto">
								</li>
							</template>
						</template>
					</ul>
				</div>
				<div class="flex justify-between items-center mt-10">
					<h2 class="font-bold text-lg">All events</h2>
				</div>
				<div class="mt-6">
					<ul class="grid grid-cols-6 gap-x-3 gap-y-5">
						<template x-for="day in calender_days">
							<li>
								<button type="button" @click="showTickets(day)" x-text="day.day"
									:class="{'bg-gray-300 text-gray-950': !day.hasEvents, 'bg-red-800 text-gray-200': day.hasEvents}" 
									class="w-full text-center py-1 rounded-full bg-gray-300"></button>
							</li>
						</template>
					</ul>
				</div>
			</div>
		</section>
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
			            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" >Event</button>
			        </li>
			       {{--  <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Edit</button>
			        </li> --}}
			        <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-styled-tab" data-tabs-target="#styled-settings" type="button" role="tab" aria-controls="settings" aria-selected="false" x-ref="viewEventTicket">Tickets</button>
			        </li>
			    </ul>
			</div>
			<div id="default-styled-tab-content">
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
            		<template x-if="chosenEvents == null || chosenEvents.length <= 0">
            			<p class="text-center py-4 ">There is no event currently scheduled for this day, you can refresh later in the day to see if an event has been scheduled for that day</p>
            		</template>
            		<template x-if="chosenEvents.length > 0">
            			<ul class="grid gap-4">
            				<template x-for="event in chosenEvents" :key="event.id">
	            				<li x-text="event.name" class="cursor-pointer" @click="showEventTickets(event, event.tickets)"></li>
	            			</template>
            			</ul>
            		</template>	
			    </div>
			    {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
			        Ticket form would be here
			    </div> --}}
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-settings" role="tabpanel" aria-labelledby="settings-tab">
			       <template x-if="chosenEvents.length <= 0 || chosenTickets.length <= 0">
			       		<p>No tickets has been created for this event yet. Check back later for the tickets for this events</p>
			       </template>
			       <template x-if="chosenTickets.length > 0">
			       		<template x-for="ticket in chosenTickets">
			       			<div >
			       				<template x-if="ticket.type.length == 10">
			            			<div class="">
										{{-- <img src="" alt=""> --}}
										<div class="bg-white px-4 py-10 pb-5 rounded w-64 text-gray-950 mt-2 text-center border border-gray-200 shadow-md hover:shadow-lg ">
											<div>
												<div class="border-b border-black">
													<h2 class="text-3xl font-bold" x-text="chosenEvent.name"></h2>
													<p class="text-sm font-bold py-2" x-text="chosenEvent.starting_time + ' ,' + chosenEvent.event_date"></p>
												</div>
												<div class="grid grid-cols-2 gap-6 text-left mt-5">
													<div class="pb-3 border-b border-gray-300">
														<p class="text-gray-600 text-sm">Ticket owner</p>
														<p class="font-bold text-lg text-black" x-text="user.nickname">CruiseHq</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-gray-600 text-sm">Promoter</p>
														<p class="font-bold text-lg text-black" x-text="chosenEvent.user.nickname">CruiseHq</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-gray-600 text-sm">Date</p>
														<p class="font-bold text-black" x-text="new Date(chosenEvent.event_date).toDateString()"></p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-gray-600 text-sm">Time</p>
														<p class="font-bold text-black" x-text="chosenEvent.starting_time">4:00 PM</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-gray-600 text-sm">Location</p>
														<p class="font-bold text-black" x-text="chosenEvent.location"></p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-gray-600 text-sm">State</p>
														<p class="font-bold text-black" x-text="chosenEvent.state"></p>
													</div>
												</div>
												<div class="mt-10">
													<p>Price : 
														<span class="font-bold text-xl">&#8358; </span>
														<span x-text="new Intl.NumberFormat().format(ticket.price)"></span>
													</p>
												</div>
											</div>
										</div>
										<div class="mt-12">
											<h2 class="font-bold text-left py-2 text-xl">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left text-gray-950 tracking-wider leading-8"></p>
										</div>
										<div class="flex justify-center items-center mb-10 mt-4">
											<button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-gray-950 text-gray-300">Get ticket</button>
										</div>
									</div>
			            		</template>		
			            		<template x-if="ticket.type.length == 17">
			            			<div>
										<div class="bg-gray-500 pt-4 pb-10 rounded w-64 mx-auto text-gray-300 mt-2 text-center">
											<p class="text-md text-gray-200 py-2 block bg-transparent" x-text="user.nickname">Light</p>
											<h2 class="font-bold text-xl py-3 text-gray-200 block bg-gray-950">General admission</h2>
											<div class="px-4">
												<h2 class="text-3xl font-bold text-gray-200" x-text="chosenEvent.name">Name of the event</h2>
												<p class="mt-4 text-sm" x-text="chosenEvent.event_date">10th of August, 2024</p>
												<p x-text="new Date(chosenEvent.event_date).toDateString()">Sunday 10th of August, 2024 @ 4:00 PM</p>
												<p x-text="chosenEvent.location">31270 Rahul Roads Beckerview, KS 94569-2627</p>
												<p x-text="chosenEvent.state + ' '+ chosenEvent.state">Lagos state</p>
												<p class="pb-4">Event Organized by: <span x-text="chosenEvent.user.nickname"></span></p>
											</div>
											<div class="mt-10">
													<p>Price : 
														<span class="font-bold text-xl">&#8358; </span>
														<span x-text="new Intl.NumberFormat().format(ticket.price)"></span>
													</p>
												</div>
										</div>

										<div class="mt-10">
											<h2 class="font-bold text-left py-2 text-xl">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left text-gray-950 tracking-wider leading-8"></p>
										</div>
										<div class="flex justify-center items-center mb-10 mt-4">
											<button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-gray-950 text-gray-300">Get ticket</button>
										</div>
									</div>
			            		</template>
			            		<template x-if="ticket.type.length == 3">
			            			<div class="">
										<div class="px-4 bg-gray-950 bg-vip-pattern py-6 pb-10 rounded w-64 mx-auto text-gray-300 mt-2 text-center shadow-md border border-gray-200 hover:shadow-3xl hover:border-gray-100 relative ">
											<div class="grid gap-4">
												<div>
													<p class="text-sm text-gray-400" x-text="user.nickname">Light's</p>
													<h2 class="font-bold text-4xl py-2 text-amber-800">VIP</h2>
													<p class="text-sm text-gray-400">ticket</p>
												</div>
												<div>
													<p x-text="chosenEvent.user.nickname" class="text-gray-200">Name of the promoter</p>
													<p class="text-gray-500">presents</p>
													<h2 class="text-4xl font-bold text-amber-600 py-3" x-text="chosenEvent.name">Name of the event</h2>
												</div>
												<div class="">
													<p class="mt-4 text-sm" x-text="chosenEvent.event_date">10th of August, 2024</p>
													<p>
														<span x-text="new Date(chosenEvent.event_date).toDateString()"></span> @ 
														<span x-text="chosenEvent.starting_time"></span>
													</p>
													<p class="mt-4 text-sm" x-text="chosenEvent.location">Location: 31270 Rahul Roads Beckerview, KS 94569-2627</p>
													<p x-text="chosenEvent.state">Lagos state</p>
												</div>
											</div>
											<div class="mt-10">
												<p>Price : 
													<span class="font-bold text-xl">&#8358; </span>
													<span x-text="new Intl.NumberFormat().format(ticket.price)"></span>
												</p>
											</div>
										</div>
									</div>
									<div class="mt-10">
										<h2 class="font-bold text-left py-2 text-xl">USP of <span x-text="ticket.type"></span></h2>
										<p x-text="ticket.type_copy" class="text-left text-gray-950 tracking-wider leading-8"></p>
									</div>
									<div class="flex justify-center items-center mb-10 mt-4">
										<button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-gray-950 text-gray-300">Get ticket</button>
									</div>
			            		</template>	
			       			</div>
			       		</template>
			       </template>
			    </div>
			</div>
	        </div>
	    </div>
	</div>

@endsection

