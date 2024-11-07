@extends('layouts.admin')

@section('title', 'View all Scheduled events')

@section('content')
	<div 	class="text-black pb-32" 
			x-data='{ events: @json($events),
						open: false,
						data: { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "" }, 
						submitForm(){
							axios.post("/promoter/dashboard/events/create", this.data)
							.then(response => console.log(response))
							.catch(error => console.log(error))
						},
						editEvent(event)
						{
							$dispatch("notify", {event: event})
						},
						fetchData(cursor)
						{
							if(typeof cursor == null)
							{
								return false;
							}
							try {
				                axios.post("/promoter/dashboard/events/paginate", {cursor: cursor})
				                .then(response => {
				                	this.events = response.data
				            	})
				                .catch(error => console.log(error))
				            } catch (error) {
				                console.error(error)
				            }
						},
						displaySideBar($event)
						{
							console.log($event.detail.event, this.data)
							this.open =  !this.open
							if(this.open)
							{
								this.data = $event.detail.event
							}
							
						} 
		}'>
		<div class="flex justify-between items-center my-4">
			<h1>Event dashboard</h1>
			<a href="/promoter/dashboard/events/create" class="px-6 py-2 bg-gray-950 text-gray-300">Create event</a>
		</div>

		{{-- <div>
			<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<th scope="col" class="px-6 py-3">Name</th>
					<th scope="col" class="px-6 py-3">State</th>
					<th scope="col" class="px-6 py-3">Date</th>
					<th scope="col" class="px-6 py-3">Time</th>
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
			                <td class="px-6 py-4">
			                	<template x-if="Date.parse(event.event_date) > Date.now()">
								    <span class="text-green-600 font-bold">Active</span>
								</template>
								<template x-if="Date.now() > Date.parse(event.event_date)">
								    <span class="text-red-600 font-bold">Done & Dusted</span>
								</template>
			                </td>
			                <td class="px-2 py-4 font-bold" >
			                	<span class="cursor-pointer text-blue-800 underline px-3" @click="editEvent(event)">Edit</span>
			                	<span class="cursor-pointer text-blue-800 underline px-3">Tickets</span>
			                </td>
						</tr>
				    </template>	
				</tbody>
			</table>
		</div> --}}
		<div class="text-sm text-gray-700 w-full text-sm text-left rtl:text-right dark:text-gray-400">
			<div class="grid grid-cols-6 gap-2 mt-2">
				<h2 class="font-bold text-left px-3 py-3">Name</h2>
				<h2 class="font-bold text-left px-3 py-3">State</h2>
				<h2 class="font-bold text-left px-3 py-3">Date</h2>
				<h2 class="font-bold text-left px-3 py-3">Time</h2>
				<h2 class="font-bold text-left px-3 py-3">Status</h2>
				<h2 class="font-bold text-left px-3 py-3">Action</h2>
			</div>
			<template x-for="event in events.data" :key="event.id">
				<div class="grid grid-cols-6 gap-3 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 py-2">
					<h2 x-text="event.name"></h2>
					<p x-text="event.state"></p>
					<p x-text="event.event_date"></p>
					<p x-text="event.starting_time"></p>
	            	<p>
	            		<template x-if="Date.parse(event.event_date) > Date.now()">
						    <span class="text-green-600 font-bold">Active</span>
						</template>
						<template x-if="Date.now() > Date.parse(event.event_date)">
						    <span class="text-red-600 font-bold">Done & Dusted</span>
						</template>
	            	</p>

	                <p class="px-2 font-bold" >
	                	<span class="cursor-pointer text-blue-800 underline px-3" @click="editEvent(event)">Edit</span>
	                	<span class="cursor-pointer text-blue-800 underline px-3">Tickets</span>
	                </p>
	                <template x-if="event.tickets.length == 0">
	                	<p class="col-span-full text-center py-2">There are tickets for this event yet, proceed to the Ticket section to create a one.</p>
	                </template>
	                <template x-if="event.tickets.length > 0">
	                	<div class="w-full col-span-full col-start-2">
	                		<div class="font-bold text-sm  w-full grid grid-cols-4 gap-3">
		                		<h4>Ticket type</h4>
		                		<h4>Ticket Access</h4>
		                		<h4 class="text-center">Total Seats</h4>
		                		<h4 class="text-center">Remaining seats</h4>
		                	</div>
		                	<template x-for="ticket in event.tickets">
			                	<div class="col-span-full col-start-2 w-full grid grid-cols-4 gap-2">
			                		<p x-text="ticket.type" class="py-2"></p>
			                		<p x-text="ticket.access_type"></p>
			                		<p x-text="ticket.total_seat" class="text-center"></p>
			                		<p x-text="ticket.available_seat" class="text-center"></p>
			                	</div>
			                </template>
	                	</div>
	                </template> 
				</div>
			</template>
		</div>
		<div @notify.window="displaySideBar"
			x-show="open"
			x-transition:enter.duration.50ms
	    	x-transition:leave.duration.200ms
	    >
			<x-sidebar-container >
				<form action="" method="post" >
				@csrf
				<div class="">
					<label for="event_name">Name of the event</label>
					<p>Hint: Make it as awesome as possible</p>
					<input type="text" name="event_name" id="event_name" required minLength="5" x-model="data.name" class="text-gray-950">
				</div>
				<div class="">
					<label for="state">State of the event</label>
					<select name="state" id="state" required x-model="data.state">
						<option value="kwara">Kwara</option>
						<option value="lagos">Lagos</option>
						<option value="abuja">Abuja</option>
					</select>
				</div>
				<div class="">
					<label for="event_date">Date of the event</label>
					<input type="date" name="event_date" id="event_date" required x-model="data.event_date">
				</div>
				<div class="">
					<label for="starting_time">Time of the event</label>
					<input type="time" name="starting_time" id="starting_time" required x-model="data.starting_time">
				</div>
				<div class="">
					<label for="promotional_copy">Promotional copy</label>
					<p>Hint: Provide a summary of the expected outcome </p>
					<input type="text" name="promotional_copy" id="promotional_copy" maxlength="2000" x-model="data.promotional_copy">
				</div>
				<div class="">
					<label for="coordinate">Coordinate</label>
					<input type="text" name="coordinate" id="coordinate" required x-model="data.coordinate">
				</div>

				<button class="px-6 py-3 bg-gray-500 border-none text-gray-950" type="submit" @click.prevent="submitForm()">Save changes</button>
			</form>
			</x-sidebar-container>
		</div>

		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-4">
			<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.prev_cursor)">Prev</button>
			<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.next_cursor)">Next</button>
		</div>
	</div>

@endsection