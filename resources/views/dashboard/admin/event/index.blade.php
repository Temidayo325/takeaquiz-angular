@extends('layouts.admin')

@section('title', 'View all Scheduled events')

@section('content')
	<div 	class="text-purple-1000 min-h-screen pb-32 md:px-10" 
			x-data='{ events: @json($events),
						open: false,
						user: JSON.parse(localStorage.getItem("user")),
						searchterm: "",
						data: { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "" }, 
						tickets: [],
						chosenEvent: {},
						submitForm()
						{
							axios.post("/promoter/dashboard/events/create", this.data)
							.then(response => console.log(response))
							.catch(error => console.log(error))
						},
						fetchData(cursor)
						{
							if(typeof cursor == null)
							{
								return false;
							}
							try {
				                axios.post("/admin/dashboard/events/paginate", {cursor: cursor})
				                .then(response => {
				                	this.events = response.data
				            	})
				                .catch(error => console.log(error))
				            } catch (error) {
				                console.error(error)
				            }
						},
						deleteEvent(id)
						{
							axios.post("/admin/dashboard/event/delete", {id: id})
							.then( ( response ) => {
								if(!response.error)
								{
									event_index = this.events.data.findIndex( (event) => event.id === id)
									this.events.data.splice(event_index, 1)
								}
								this.toast("Event deleted successfully", "green")
							})
							.catch((error) => {
								this.toast("Encountered an error while trying to delete event", "red")
							})
						},
						togglePremium(id)
						{
							this.toast("Modifying event premium status ...", "blue")
							axios.post("/admin/dashboard/event/premium/toggle", {id: id})
							.then( ( response ) => {
								if(!response.error)
								{
									let event_index = this.events.data.findIndex( (event) => event.id === id)
									this.events.data[event_index].isPremium = (this.events.data[event_index].isPremium == 1) ? 0 : 1
									this.toast("Event premium status modified successfully", "green")
								}
							})
							.catch( (error) => {
								this.toast("Unable to make event a premium event", "red")
							})
						},
						showEventTicket(event, tickets)
						{
							console.log(tickets)
							this.tickets = tickets
							this.chosenEvent = event
							$refs.toggleButton.dispatchEvent(new Event("click"))
						},
						searchTerm()
						{
							this.toast("Searching for event name with " + this.searchterm + " ...", "blue")
							axios.post("/admin/dashboard/events/search", {searchTerm: this.searchterm})
							.then( ( response ) => {
								if(!response.error)
								{
									this.toast("Search results returned successfully", "green")
									this.events = response.data.events
								}
							})
							.catch( (error) => {
								console.log(error)
								this.toast("Error encountered while searching", "red")
							})
						},
						toast(text, background)
						{
							Toastify({
							  text: text, 
							  style: {
							    background: background,
							    color: "white"
							  }
							}).showToast();
						},
		}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">View all the available events, to view more details about the events, click on the event card and a sidebar would pop out revealing more information ablut the event. Click the button below to create more events</p>
				<a href="/promoter/dashboard/event/create" class="px-6 py-3 font-bold md:font-normal bg-red-1000 text-gray-200">Create event</a>
			</div>
			<img src="{{asset('/images/party.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="flex justify-between items-center my-10">
			<h1 class="font-bold text-xl">Event dashboard</h1>
			<div x-show="events.data.length > 0">
				<form action="" method="" class="flex justify-start " @submit.prevent="searchTerm()">
					@csrf
					<input type="text" class="w-72 p-2" x-model="searchterm" placeholder="Event name e.g. Block party" @input.debounce.500ms="searchTerm()">
					{{-- <button type="submit" class="bg-gray-950 text-gray-200 px-6 py-2">Search</button> --}}
				</form>
			</div>
		</div>
		
		<ul class="grid grid-cols-3 gap-x-7 gap-y-10">
			<template x-for="event in events.data" :key="event.id">
				<li class="hover:shadow-2xl duration-700 hover:border hover:border-gray-400 p-5 bg-gray-100 md:bg-white md:border md:border-gray-200 shadow-md md:shadow-sm cursor-pointer relative " >
					<div class="grid gap-2">
						<div class="flex justify-between items-center">
							<p x-text="new Date().toDateString(event.event_date)" class=""></p>
							<template x-if="event.isPremium == 1">
							    <span class="text-purple-1000 text-center text-2xl font-bold ">&#9824;</span>
							</template>
						</div>
						<img :src="`{{ asset('/images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-full ">
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
							<p class="mt-2">
								<svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
								<span x-text="event.location" class="text-sm"></span>
							</p>
						</div>
					</div>
					<p class="mt-2 flex justify-between items-baseline">
	            		<template x-if="Date.parse(event.event_date) > Date.now()">
						    <span class="text-green-600 font-bold">Upcoming</span>
						</template>
						<template x-if="Date.now() > Date.parse(event.event_date)">
						    <span class="text-red-600 font-bold">Done & Dusted</span>
						</template>
						
	            	</p>
	            	<div class="font-body text-sm">
	            		<h4 class="font-bold  mt-3 mb-2">Actions</h4>
	            		<div class="flex justify-evenly items-center">
	            			<button class="cursor-pointer text-blue-800 underline" @click="showEventTicket(event, event.tickets)" title="View ticket performance for this event">Tickets</button>
		                	<button class="cursor-pointer text-red-800 underline px-3" @click="deleteEvent(event.id)" title="Click this button to delete this event">Delete</button>
		                	<div>
		                		<template x-if="event.isPremium ">
								    <button class="cursor-pointer text-gray-950 underline" @click="togglePremium(event.id)" title="Click this button to remove the premium tag on this event">Inactivate premium</button>
								</template>
								<template x-if="!event.isPremium">
								    <button class="cursor-pointer text-gray-950 underline" @click="togglePremium(event.id)" title="Click this button to make this event a premium event">Activate premium</button>
								</template>
		                	</div>
	            		</div>
	            	</div>      
				</li>
			</template>
		</ul>
		<template x-if="events.data.length <= 0">
			<h2 class="text-center my-6 font-bold text-lg ">You have not created any event yet. </h2>
		</template>
		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-10">
			<template x-if="events.prev_cursor != null">
				<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.prev_cursor)">Prev</button>
			</template>
			<template x-if="events.next_cursor != null">
				<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.next_cursor)">Next</button>
			</template>
		</div>
	    <!-- drawer init and show -->
		<div class="text-center hidden">
		   <button class="" 
		   type="button" 
		   data-drawer-target="ticket-side-bar" 
		   data-drawer-show="ticket-side-bar" 
		   aria-controls="ticket-side-bar" 
		   data-drawer-placement="right"
		   x-ref="toggleButton"
		   ></button>
		</div>

		<!-- drawer component -->
		<div id="ticket-side-bar" class="fixed top-0 right-0 z-40 w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-purple-100 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
		    <button type="button" data-drawer-hide="ticket-side-bar" aria-controls="ticket-side-bar" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
		        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
		    </button>
		  <div class="py-4 overflow-y-auto mt-10">
		      	<template x-if="tickets.length <= 0">
		      		<div>
		      			<h2 class="text-purple-1000 text-center font-body leading-8 my-32">This event does not have a ticket yet, remind the event Organizer to create the ticket desired.</h2>
		      		</div>
		      	</template>
		      	<template x-if="tickets.length > 0">
		      		<ul class="grid gap-12">
		      			<template x-for="ticket in tickets" :key="ticket.id">
		      				<div>
		      					<template x-if="ticket.type == 'Early bird'">
		      						<li class="p-5 bg-white border border-gray-100 shadow-lg cursor-pointer">
				      					<h2 class="font-bold tracking-widest  font-display text-center text-3xl" x-text="ticket.type"></h2>
				      					<div class="mt-5">
				      						<p>Total tickets<span class="font-bold text-lg ml-3" x-text="ticket.total_seat"></span><span></span></p>
				      						<p>Unsold tickets <span class="ml-3 font-bold text-lg" x-text="ticket.available_seat"></span><span></span></p>
				      						<p>Ticket sales progress <span class="ml-3 font-bold text-xl text-red-900">&#8358;</span><span class="text-red-900 font-bold text-xl" x-text="new Intl.NumberFormat().format(ticket.price * (ticket.total_seat - ticket.available_seat))"></span><span></span></p>
				      					</div>
				      				</li>
		      					</template>
		      					<template x-if="ticket.type == 'General admission'">
		      						<li class="p-5 bg-greyish border border-gray-100 shadow-lg cursor-pointer">
				      					<h2 class="font-bold tracking-widest  font-display text-center text-3xl" x-text="ticket.type"></h2>
				      					<div class="mt-5">
				      						<p>Total tickets<span class="font-bold text-lg ml-3" x-text="ticket.total_seat"></span><span></span></p>
				      						<p>Unsold tickets <span class="ml-3 font-bold 
				      						<p>Ticket sales progress <span class="ml-3 font-bold text-xl text-red-900">&#8358;</span><span class="text-red-900 font-bold text-xl" x-text="new Intl.NumberFormat().format(ticket.price * (ticket.total_seat - ticket.available_seat))"></span><span></span></p>
				      					</div>
				      				</li>
		      					</template>
		      					<template x-if="ticket.type == 'VIP'">
		      						<li class="p-5 bg-gray-950 text-gray-200 border border-gray-100 shadow-lg cursor-pointer">
				      					<h2 class="font-bold tracking-widest text-red-900 font-display text-center text-3xl" x-text="ticket.type"></h2>
				      					<div class="mt-5">
				      						<p>Total tickets<span class="font-bold text-lg ml-3" x-text="ticket.total_seat"></span><span></span></p>
				      						<p>Unsold tickets <span class="ml-3 font-bold 
				      						<p>Ticket sales progress <span class="ml-3 font-bold text-xl text-red-900">&#8358;</span><span class="text-red-900 font-bold text-xl" x-text="ticket.price * (ticket.total_seat - ticket.available_seat)"></span><span></span></p>
				      					</div>
				      				</li>
		      					</template>
		      				</div>
		      			</template>
		      		</ul>
		      	</template>
		   </div>
		</div>
	</div>

@endsection