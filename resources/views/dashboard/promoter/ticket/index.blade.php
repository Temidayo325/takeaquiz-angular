@extends('layouts.admin')

@section('title', 'Ticket dashboard')

@section('content')
	{{-- <x-off-canvas-side-bar></x-off-canvas-side-bar> --}}
	<div class="" x-data='{ events: @json($events),
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
							
						},
						deleteTicket(id)
						{
							axios.post("/promoter/dashboard/ticket/delete", {id: id})
							.then( ( response ) => {
								this.events = JSON.parse(response.events)
								$nextTick()
								console.log(response)
							})
							.catch(error => console.log(error))
						} 
		}'>
		<div class="text-black flex justify-between items-center mt-5 mb-3">
			<h1 class="font-bold text-lg">Ticket dashboard</h1>
			<a href="" class="bg-gray-950 text-gray-300 px-7 py-3">Create new ticket</a>
		</div>
		<h2 class="font-bold my-2 text-lg">Events and their corresponding tickets</h2>
		<ul>
			<template x-if="events.data.length <= 0">
				<p>You do not have an event you can create a ticket for, kindly <a href="/promoter/dashboard/events/create">click here to create an event</a>  to get started</p>
			</template>
			<template x-if="events.data.length > 0">
				<template  x-for='event in events.data'>
					<ol>
						<li class="bg-gray-100 hover:bg-gray-200 shadow-sm hover:shadow-lg py-2 px-2 my-4">
							<p x-text="'Event: ' + event.name" class="mb-3 font-bold text-md"></p>
							<template x-if="event.tickets.length == 0">
	                			<p class="col-span-full text-center py-2">There are tickets for this event yet, proceed to the Ticket section to create a one.</p>
	                		</template>
			                <template x-if="event.tickets.length > 0">
			                	<div class="w-full ml-14">
			                		<div class="font-bold text-sm w-full grid grid-cols-6 gap-4">
				                		<h4>Ticket type</h4>
				                		<h4>Ticket Access</h4>
				                		<h4>Ticket price</h4>
				                		{{-- <h4 class="text-center">Total tickets</h4> --}}
				                		<h4 class="text-center">Unbooked tickets</h4>
				                		{{-- <h4>Promotional copy</h4> --}}
				                		<h4>Actions</h4>
				                	</div>
				                	<template x-for="ticket in event.tickets">
					                	<div class="w-full grid grid-cols-6 gap-2 py-2">
					                		<p x-text="ticket.type" class=""></p>
					                		<p x-text="ticket.access_type"></p>
					                		<p x-text="ticket.price"></p>
					                		{{-- <p x-text="ticket.total_seat" class="text-center"></p> --}}
					                		<p x-text="ticket.available_seat" class="text-center"></p>
					                		{{-- <p x-text="ticket.type_copy"></p> --}}
					                		<p class="flex justify-start gap-4">
					                			<span class="text-blue-600 underline cursor-pointer">View</span>
					                			<span class="text-blue-600 underline cursor-pointer">Edit</span>
					                			<button class="text-red-600 underline cursor-pointer border-none" @click="deleteTicket(ticket.id)">Delete</button>
					                		</p>
					                	</div>
					                </template>
			                	</div>
			                </template> 
						</li>
					</ol>
				</template>
			</template>			
		</ul>
		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-4">
			<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.prev_cursor)">Prev</button>
			<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.next_cursor)">Next</button>
		</div>
	</div>

@endsection

