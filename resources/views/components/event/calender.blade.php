@props(['events', 'events_today', 'premium_events'])
<div class="text-purple-1000 px-4 z-20" x-data='{ user: {},
		events: @json($events),
		events_today: @json($events_today),
		premium_events: @json($premium_events),
		{{-- tags: @json($tags), --}}
		state: "",
		searchParameter: "",
		chosenEvents: [],
		chosenEvent: null,
		chosenTickets: [],
		start_date: new Date(),
		calender_days: [],
		init() {
        	this.user = JSON.parse(sessionStorage.getItem("user"))
        	this.calender_days = this.getDates(this.events)
        	console.log(this.tags)
   		},
   		showTickets(events)
   		{
   			this.chosenEvents = events.events
   			$refs.sideBarButton.dispatchEvent(new Event("click"))
   		},
   		getDates(events)
   		{
   			let days = []
   			let event_day = null
   			for (let i = 0; i <= 30; i++) {
			    const currentDate = new Date(this.start_date);
			    currentDate.setDate(this.start_date.getDate() + i);

			    event_day = events.filter( (event) => currentDate.getDate() == new Date(event.event_date).getDate())
			    days.push({day: currentDate.getDate(), events: event_day, hasEvents: (event_day.length > 0 ) ? true : false, dayOfTheWeek: currentDate.toDateString().slice(0, 3)})
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
   		},
   		sortByState()
   		{
   			try {
                axios.post("/events/filterByState", {state: this.state})
                .then(response => {
                	this.calender_days = this.getDates(response.data.events)
                	this.events_today = response.data.events_today
                	this.premium_events = response.data.premium_events
            	})
                .catch(error => console.log(error))
            } catch (error) {
                console.error(error)
            }
   		},
   		sortByName()
   		{
   			alert("Search by name")
   		}
	}'>
		<section {{ $attributes->merge(['class' => 'pb-12']) }}>
			<div class="md:py-10 md:px-10">
				<template x-if="events_today.length > 0">
					<div class="mt-5 md:mt-10 text-purple-1000">
						<h2 class="font-normal text-greyish font-body text-3xl">Today's update</h2>
						<p class="text-greyish mt-3">Pure Vibes: Because every day should feel like Detty December</p>
						<ul class="mt-7 mb-10 grid gap-5 text-greyish md:mt-12 md:px-12">
							<template x-for="event in events_today">
								<li class="border-t-4 border-greyish py-5 px-4 shadow-lg md:shadow-sm hover:scale-105 hover:shadow-md transition duration-800 ease-in-out md:border md:border-gray-300">
									<div class="grid gap-2 md:flex md:justify-start md:items-center md:gap-5">
										<p x-text="new Date().toDateString()" class="md:hidden"></p>
										<img :src="`{{ asset('./images/fliers') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64">
										<div>
											<h2 x-text="event.name" class="text-2xl"></h2>
											<p x-text="new Date().toDateString()" class="hidden md:block my-2"></p>
											<div class="flex justify-start items-center gap-5 mt-1">
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">  <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" /></svg>
													<span x-text="event.state"></span>
												</p>
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
													<span x-text="event.starting_time"></span>
												</p>
											</div>
											<p class="flex justify-start items-center gap-1 mt-2">
												<svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
												<span x-text="event.location" class="text-sm"></span>
											</p>
										</div>
									</div>
								</li>
							</template>
						</ul>
					</div>
				</template>
				<template x-if="premium_events.length > 0">
					<div class="mt-5 mb-6 md:mt-10 text-greyish-1000">
						<h2 class="font-normal text-greyish font-body text-3xl">Premium events</h2>
						<ul class="mt-10 grid gap-6 md:gap-12 md:px-12">
							<template x-for="event in premium_events">
								<li class="border-t-4 border-greyish py-5 px-4 shadow-lg md:shadow-sm hover:scale-105 hover:shadow-md transition duration-800 ease-in-out md:border md:border-gray-300 md:grid md:grid-cols-2">
									<div class="grid gap-2 md:flex md:justify-start md:items-center md:gap-5">
										<p x-text="new Date().toDateString()" class="md:hidden"></p>
										<img :src="`{{ asset('./images/fliers') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64">
										<div>
											<h2 x-text="event.name" class="text-2xl"></h2>
											<p x-text="new Date().toDateString()" class="hidden md:block my-2"></p>
											<div class="flex justify-start items-center gap-5 mt-1">
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">  <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" /></svg>
													<span x-text="event.state"></span>
												</p>
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
													<span x-text="event.starting_time"></span>
												</p>
											</div>
											<p class="flex justify-start items-center gap-1 mt-2">
												<svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
												<span x-text="event.location" class="text-sm"></span>
											</p>
										</div>
									</div>
									<div x-show="event.isPremium == 1" class="mt-3 ">
										<template x-if="event.eventmedia != null">
											<video  :src="`{{ asset('./images') }}/${event.eventmedia.video_gallery}`" title="Promotional video for event" controls="controls" class="border border-gray-800 md:w-full" ></video>
										</template>
									</div>
								</li>
							</template>
						</ul>
					</div>
				</template>
			</div>
			<div class="w-full px-4 md:px-10 bg-gray-200 md:bg-gray-300 md:pt-3 pb-12 md:grid md:grid-cols-2 md:items-center md:py-12">
				<h2 class="font-display font-normal text-4xl pt-5 text-purple-1000 md:text-greyish md:pt-10 md:hidden tracking-wider ">Cruise Calender</h2>
				<p class="md:hidden leading-8 tracking-wide font-normal font-body mt-4">We offer a 30-day event view to keep things simple. Scheduled event dates are highlighted, while empty ones remain plain.</p>
				<div>
					<div class="mt-3 text-greyish font-body md:mt-6 md:px-4">
						{{-- <h4 class="font-body font-normal md:hidden text-sm mb-3 text-purple-1000 md:text-greyish ">Filters</h4> --}}
						<div class="md:flex md:justify-start">
							<form @submit.prevent="sortByState()" class="mt-8 md:flex md:justify-start md:items-center md:gap-3 text-purple-1000 md:text-greyish">
								<div class="">
									<label for="state" class="font-body text-sm md:inline">Filter by state</label>
									<select name="state" id="state" @change="sortByState()" class="border border-purple-100 focus:outline-none focus:ring-0 focus:border-none focus:shadow-lg focus:border focus:border-gray-100 mt-2 w-full md:w-5/6 md:border-gray-300" x-model="state">
										<option value="" disabled>Select desired state</option>
										<option value="all">All states</option>
										<option value="abuja">Abuja</option>
										<option value="kwara">Kwara</option>
										<option value="lagos">Lagos</option>
										<option value="osun">Osun</option>
									</select>
								</div>
							</form>
						</div>
					</div>
					<div class="mt-10 md:px-10 md:w-5/6">
						<div class="grid grid-cols-7 gap-x-3 gap-y-8">
							<template x-for="i in 7">
						        <p x-text="calender_days[i].dayOfTheWeek" class="text-sm text-purple-1000 text-center font-bold"></p>
						    </template>
						</div>
						<ul class="mt-2 grid grid-cols-7 gap-x-3 gap-y-6">
							<template x-for="day in calender_days">
								<li>
									<button type="button" @click="showTickets(day)" x-text="day.day"
										{{-- :class="{'bg-cover bg-purple-1000 md:bg-gray-700  bg-blend-multiply text-gray-100': day.hasEvents, 'text-purple-1000': !day.hasEvents}"  --}}
										:class="{'text-purple-1000 border border-red-1000': day.hasEvents, 'text-purple-1000': !day.hasEvents}"
										class="text-center px-2 md:px-3 md:py-2 py-1 rounded-full bg-gray-300 text-sm"
										{{-- :style="day.hasEvents && day.events[0]?.flier ? `background-image: url('{{ asset('./images/fliers') }}/${day.events[0].flier}')` : ''" --}}
										></button>
								</li>
							</template>
						</ul>
					</div>
				</div>
				<div class="hidden md:grid text-purple-1000">
					<h1 class="text-7xl font-display ">Checkout Cruise Calender for the next 30 days</h1>
					<p class="leading-8 tracking-wide font-body mt-4">We provide a 30 days view of events so as not to overwhelm you. Dates with events scheduled for them is highlighted while those with zero events yet are plain</p>
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
            			<ul class="grid gap-10 pb-12">
            				<template x-for="event in chosenEvents" :key="event.id">
	            				<li class="border shadow-lg md:shadow-sm border-gray-200 bg-gray-200 px-2 py-5 cursor-pointer rounded text-purple-1000 hover:shadow-md">
									<div class="grid gap-2">
										<p x-text="new Date(event.event_date).toDateString()" class="text-sm md:text-md"></p>
										<img :src="`{{ asset('./images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto">
										<div class="pt-2 pb-5 border-b border-gray-700">
											<h2 x-text="event.name" class="text-xl md:text-2xl font-body font-bold"></h2>
											<div class="flex justify-start text-sm md:text-md items-center gap-5 mt-3">
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" /></svg>

													<span x-text="event.state"></span>
												</p>
												<p class="flex justify-start items-center gap-1">
													<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
													<span x-text="event.starting_time"></span>
												</p>
											</div>
											<p class="flex justify-start items-start gap-1 mt-3">
												<svg class="w-7 h-7 text-purple-1000" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
												<span x-text="event.location" class="text-sm "></span>
											</p>
										</div>
										<div class="py-2 grid gap-3 mt-2 text-purple-1000">
											<div>
												<h3 class="text-sm font-bold ">Event duration</h3>
												<p x-text="event.duration"></p>
											</div>

											<div>
												<h3 class="text-sm font-bold ">Recomended Audience</h3>
												<p x-text="event.audience"></p>
											</div>

											<div>
												<h3 class="text-sm font-bold ">Dress code</h3>
												<p x-text="event.dress_code"></p>
											</div>

											<div>
												<h3 class="text-sm font-bold ">For  more information</h3>
												<p x-text="event.contact_information"></p>
											</div>
											<div>
												<button @click="showEventTickets(event, event.tickets)" class="bg-purple-1000 text-gray-300 hover:bg-purple-900 hover:text-gray-100 py-3 w-full text-center text-white hover:shadow-md">View Event ticket</button>
											</div>
										</div>
									</div>
								</li>
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
			       			<div class="grid gap-8">
			       				<template x-if="ticket.type.length == 10">
			            			<div class="">
										{{-- <img src="" alt=""> --}}
										<div class="bg-white px-4 py-10 pb-5 rounded w-48 md:w-64 text-purple-1000 font-body mt-2 text-center border border-gray-200 shadow-md hover:shadow-lg ">
											<div>
												<div class="border-b border-black">
													<h2 class="text-3xl font-display" x-text="chosenEvent.name"></h2>
													<p class="text-sm py-3" x-text="chosenEvent.starting_time + ' , ' + chosenEvent.event_date"></p>
												</div>
												<div class="grid grid-cols-2 gap-6 text-left mt-5">
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Ticket owner</p>
														<p class="text-lg text-purple-1000" x-text="user != null ? user.nickname : 'My CruiseID'">CruiseHq</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Organizer</p>
														<p class="text-lg text-purple-1000" x-text="chosenEvent.user.nickname">CruiseHq</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Date</p>
														<p class="text-purple-1000" x-text="new Date(chosenEvent.event_date).toDateString()"></p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Time</p>
														<p class="text-purple-1000" x-text="chosenEvent.starting_time">4:00 PM</p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">Location</p>
														<p class="text-purple-1000" x-text="chosenEvent.location"></p>
													</div>
													<div class="pb-3 border-b border-gray-300">
														<p class="text-greyish text-sm">State</p>
														<p class="text-purple-1000" x-text="chosenEvent.state"></p>
													</div>
												</div>
												<div class="mt-10">
													<p>	
														<span class="font-bold text-xl text-purple-1000">&#8358; </span>
														<span class="font-bold text-xl text-purple-1000" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
													</p>
												</div>
											</div>
										</div>
										<div class="mt-6 md:mt-10 text-purple-1000">
											<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
										</div>
										<div class="flex justify-center items-center mb-10 mt-4">
											<button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-red-1000 text-gray-100">Get ticket</button>
										</div>
									</div>
			            		</template>		
			            		<template x-if="ticket.type.length == 17">
			            			<div>
										<div class="bg-greyish pt-4 pb-10 rounded w-48 md:w-64 mx-auto text-gray-300 mt-2 text-center text-purple-1000">
											<p class="text-md py-2 block bg-transparent" x-text="user != null ? user.nickname : 'My CruiseID'">Light</p>
											<h2 class="text-md py-3 block text-greyish bg-purple-1000">General admission</h2>
											<div class="px-4">
												<h2 class="text-4xl font-display text-red-1000 my-2" x-text="chosenEvent.name">Name of the event</h2>
												<p class="mt-4 text-sm" x-text="chosenEvent.event_date">10th of August, 2024</p>
												<p x-text="new Date(chosenEvent.event_date).toDateString()" class="my-3">Sunday 10th of August, 2024 @ 4:00 PM</p>
												<p x-text="chosenEvent.location" class="my-2">31270 Rahul Roads Beckerview, KS 94569-2627</p>
												<p x-text="chosenEvent.state">Lagos state</p>
												<p class="pb-4">Event Organized by: <span x-text="chosenEvent.user.nickname"></span></p>
											</div>
											<div class="mt-10">
												<p>	
													<span class="font-bold text-xl text-red-1000">&#8358; </span>
													<span class="font-bold text-xl text-red-1000" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
												</p>
											</div>
										</div>

										<div class="mt-6 md:mt-10 text-purple-1000">
											<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
										</div>
										<div class="flex justify-center items-center mb-10 mt-4">
											<button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-red-1000 text-gray-100">Get ticket</button>
										</div>
									</div>
			            		</template>
			            		<template x-if="ticket.type.length == 3">
			            			<div class="">
										<div class="px-4 bg-purple-1000 py-6 pb-10 rounded w-48 md:w-64 mx-auto text-gray-300 mt-2 text-center shadow-md border border-gray-200 text-greyish hover:shadow-3xl hover:border-gray-100 relative ">
											<div class="grid gap-4">
												<div>
													<p class="text-sm " x-text="user != null ? user.nickname : 'My CruiseID'">Light's</p>
													<h2 class="font-bold text-4xl py-2 text-red-1000">VIP</h2>
													<p class="text-sm">ticket</p>
												</div>
												<div>
													<p x-text="chosenEvent.user.nickname" class="">Name of the Organizer</p>
													<p class="">presents</p>
													<h2 class="text-4xl font-display text-red-1000 py-3" x-text="chosenEvent.name">Name of the event</h2>
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
												<p>	
													<span class="font-bold text-xl text-red-1000 font-body">&#8358; </span>
													<span class="font-bold text-xl text-red-1000 font-body" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
												</p>
											</div>
										</div>
										<div class="mt-6 md:mt-10 text-purple-1000">
											<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
											<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
										</div>
										<div class="flex justify-center items-center mb-10 mt-4">
											<button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-red-1000 text-gray-100">Get ticket</button>
										</div>
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