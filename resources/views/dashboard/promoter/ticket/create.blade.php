@extends('layouts.admin')

@section('title', 'Create a ticket')

@section('content')
	<div x-data='{ events: @json($events),
					ticket: { "event_id": "", "price": "", "total_seat": "", "available_seat": "", "ticket_type": "", "type_copy" : "", "access_type": ""},
    				addEvent(eventId){
    					this.ticket.event_id = eventId
    				},
					createTicket(){
						console.log(this.ticket, this.access_type)
						axios.post("/promoter/dashboard/tickets/create", this.ticket)
							.then( ( response ) => {
								this.events = JSON.parse(response.events)
								$nextTick()
								this.ticket = { "event_id": "", "price": "", "total_seat": "", "available_seat": "", "ticket_type": "", "type_copy" : "", "access_type": ""}
								console.log(response)
							})
							.catch(error => console.log(error))
					}
	}'>
		<div class="my-4 grid gap-3">
			<h1 class="font-bold text-lf">Ticket dashboard</h1>
			{{-- <a href="/promoter/dashboard/events/create" class="px-6 py-2 bg-gray-950 text-gray-300">Create event</a> --}}
			<h3>Upcoming events and tickets</h3>
			<p>Click on an event to see the available tickets or create an event</p>
		</div>
		<div class="flex justify-center items-center md:mt-12">
			<template x-if="events.data.length <= 0">
				<h3>You do not any event you can create a ticket for, <a href="/promoter/dashboard/events/create">Click here</a>  to create an event</h3>
			</template>
		</div>
		<div>
			<ul class="grid md:grid-cols-4 md:gap-4">
				<template x-for="event in events.data">
					<li class="bg-gray-300 hover:bg-gray-400 shadow hover:shadow-3xl hover:border hover:border-gray-100 rounded">
						<button @click="addEvent(event.id)" 
								class="text-center font-bold px-4 cursor-pointer py-4" 
								data-drawer-target="drawer-right-example" 
								data-drawer-show="drawer-right-example" data-drawer-placement="right" 
								aria-controls="drawer-right-example" 
								id="right-drawer-button"
								x-text="event.name"></button>
					</li>
				</template>
			</ul>
		</div>
		<!-- drawer component -->
      <div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-6/12 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
         <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close menu</span>
         </button>
         <div class="mt-20 ">
              <form action="" method="post" @submit.prevent="createTicket()" class="w-6/12 grid gap-3 my-5 mx-auto">
					<div class="">
						<label for="price">Price</label>
						<input type="tel" name="price" id="price" x-model="ticket.price">
					</div>
					<div>
						<label for="total_seat">Expected seat number</label>
						<input type="tel" name="total_seat" id="total_seat" x-model="ticket.total_seat">
					</div>
					<div>
						<label for="available_seat">Available seat</label>
						<input type="tel" name="available_seat" id="available_seat" x-model="ticket.available_seat" readonly>
					</div>
					<div>
						<label for="ticket_type">Ticket type</label>
						<select name="ticket_type" id="ticket_type" x-model="ticket.ticket_type">
							<option value="Early bird">Early bird</option>
							<option value="General admission">General admission</option>
							<option value="VIP">VIP</option>
						</select>
					</div>
					<div>
						<label for="access_type">Ticket access type</label>
						<select name="access_type" id="access_type" x-model="ticket.access_type">
							<option value="Free">Free</option>
							<option value="Purchase">Purchase</option>
						</select>
					</div>
					<div>
						<label for="type_copy">Short ticket copy</label>
						<p class="text-gray-500 textsm text-left">Some interesting thing that makes this ticket type ideal (USP)</p>
						<textarea name="type_copy" id="type_copy" x-model="ticket.type_copy"></textarea>
					</div>
					<div class="flex justify-center items-center">
						<button class="bg-gray-950 text-gray-200 px-10 py-3">Create ticket</button>
					</div>
			</form>
         </div>
      </div>
		
	</div>
@endsection

