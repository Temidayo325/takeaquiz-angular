@extends('layouts.admin')

@section('title', 'View all Scheduled events')

@section('content')
	<div 	class="text-black pb-32 md:px-6" 
			x-data='{ events: @json($events),
						open: false,
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
									this.events = JSON.parse(response.events)
								}
								$nextTick()
								console.log(response)
							})
							.catch(error => console.log(error))
						},
						togglePremium(id)
						{
							axios.post("/admin/dashboard/event/premium/toggle", {id: id})
							.then( ( response ) => {
								if(!response.error)
								{
									this.events = JSON.parse(response.events)
								}
								$nextTick()
								console.log(response)
							})
							.catch(error => console.log(error))
						},
						showEventTicket(event, tickets)
						{
							{{-- console.log($refs.toggleButton) --}}
							this.tickets = tickets
							this.chosenEvent = event
							$refs.toggleButton.dispatchEvent(new Event("click"))
						},
						searchTerm()
						{

						}
		}'>
		<div class="flex justify-between items-center my-10">
			<h1 class="font-bold text-2xl">Event dashboard</h1>
			<div>
				<form action="" method="" class="flex justify-start " @submit.prevent="searchTerm()">
					<input type="text" class="w-64 p-2" x-model="searchterm">
					<button class="bg-gray-950 text-gray-200 px-6 py-2">Search</button>
				</form>
			</div>
		</div>
		
		<div>
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<th scope="col" class="px-6 py-3">Name</th>
					<th scope="col" class="px-6 py-3">State</th>
					<th scope="col" class="px-6 py-3">Date</th>
					<th scope="col" class="px-6 py-3">Time</th>
					<th scope="col" class="px-6 py-3">Premium</th>
					<th scope="col" class="px-6 py-3">Status</th>
					<th scope="col" class="px-6 py-3">Action</th>
				</thead>
				<tbody>
					<template x-for="event in events.data" :key="event.id">
				        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
				        	<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" x-text="event.name"></th>
			                <td class="px-6 py-4" x-text="event.state"></td>
			                <td class="px-6 py-4" x-text="event.event_date"></td>
			                <td class="px-6 py-4" x-text="event.starting_time"></td>
			                <td class="px-6 py-4 text-center">
			                	<template x-if="event.isPremium ">
								    <span class="text-gray-950 text-center text-2xl font-bold">&#9824;</span>
								</template>
								<template x-if="!event.isPremium">
								    <span class="text-red-600 font-bold">Normal</span>
								</template>
			                </td>
			                <td class="px-6 py-4">
			                	<template x-if="Date.parse(event.event_date) > Date.now()">
								    <span class="text-green-600 font-bold">Upcoming</span>
								</template>
								<template x-if="Date.now() > Date.parse(event.event_date)">
								    <span class="text-red-600 font-bold">Done & Dusted</span>
								</template>
			                </td>
			                <td class="px-2 py-4 font-bold" >
			                	<button class="cursor-pointer text-blue-800 underline px-3" @click="showEventTicket(event, event.tickets)">Tickets</button>
			                	<button class="cursor-pointer text-red-800 underline px-3" @click="deleteEvent(event.id)">Delete</button>
			                	<div>
			                		<template x-if="event.isPremium ">
									    <button class="cursor-pointer text-gray-950 underline px-3" @click="togglePremium(event.id)">Inactivate premium</button>
									</template>
									<template x-if="!event.isPremium">
									    <button class="cursor-pointer text-gray-950 underline px-3" @click="togglePremium(event.id)">Activate premium</button>
									</template>
			                	</div>
			                </td>
						</tr>
				    </template>	
				</tbody>
			</table>
		</div>
		
		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-4">
			<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.prev_cursor)">Prev</button>
			<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.next_cursor)">Next</button>
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
		<div id="ticket-side-bar" class="fixed top-0 right-0 z-40 w-64 md:w-72 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
		    <button type="button" data-drawer-hide="ticket-side-bar" aria-controls="ticket-side-bar" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
		        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
		    </button>
		  <div class="py-4 overflow-y-auto mt-10">
		      	<template x-if="tickets.length <= 0">
		      		<div>
		      			<h2 class="text-gray-950 text-center font-bold">This even does not have a ticket yet, remind the event promoter to create the ticket desired.</h2>
		      		</div>
		      	</template>
		      	<template x-if="tickets.length > 0">
		      		<ul class="grid gap-6">
		      			<template x-for="ticket in tickets" :key="ticket.id">
		      				<li class="p-3 text-gray-950 border border-gray-400 shadow">
		      					<div class="flex justify-between ">
		      						<p x-text="chosenEvent.event_date"></p>
		      						<p x-text="chosenEvent.starting_time"></p>
		      					</div>
		      					<h2 class="font-bold text-center text-3xl" x-text="chosenEvent.name"></h2>
		      					<div class="flex justify-start gap-3">
		      						<p>Total seats <span x-text="ticket.total_seat"></span><span></span></p>
		      						<p>Unfilled seats <span x-text="ticket.available_seat"></span><span></span></p>
		      						<p>Ticket sales progress <span x-text="ticket.price * (ticket.total_seat - ticket.available_seat)"></span><span></span></p>
		      					</div>
		      				</li>
		      			</template>
		      		</ul>
		      	</template>
		   </div>
		</div>
	</div>

@endsection