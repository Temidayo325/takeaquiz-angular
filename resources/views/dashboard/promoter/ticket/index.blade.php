@extends('layouts.admin')

@section('title', 'Ticket dashboard')

@section('content')
	{{-- <x-off-canvas-side-bar></x-off-canvas-side-bar> --}}
	<div class="md:px-8" x-data='{ events: @json($events),
						open: false,
						viewToggle: false,
						editToggle: false,
						chosenTicket: null,
						chosenAttendance: [],
						chosenEvent: null,
						typeLength: 0,
						data: { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "" }, 
						submitForm()
						{
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
						},
						viewTicket(ticket, event)
						{
							this.chosenTicket = ticket
							this.chosenEvent = event
							this.chosenAttendance = ticket.attendance
							console.log(event)
							this.viewToggle = true
							this.editToggle = false
							this.typeLength = parseInt(ticket.type.trim().length)
							sessionStorage.setItem("ticket", JSON.stringify(ticket));
							$refs.sideBarButton.dispatchEvent(new Event("click"))
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
					<ol class="grid gap-20">
						<li class="bg-gray-100 hover:bg-gray-200 shadow-sm hover:shadow-lg py-2 px-2 my-4">
							<p x-text="'Event: ' + event.name" class="mb-3 font-bold text-md"></p>
							<template x-if="event.tickets.length == 0">
	                			<p class="col-span-full text-center py-2">There are no tickets for this event yet, proceed to the Ticket section to create a one.</p>
	                		</template>
			                <template x-if="event.tickets.length > 0">
			                	<div class="w-full ml-14">
			                		<div class="font-bold text-sm w-full grid grid-cols-6 gap-4">
				                		<h4>Ticket type</h4>
				                		<h4>Ticket Access</h4>
				                		<h4>Ticket price</h4>
				                		<h4 class="text-center">Total tickets</h4>
				                		<h4 class="text-center">Unbooked tickets</h4>
				                		<h4>Actions</h4>
				                	</div>
				                	<template x-for="ticket in event.tickets">
					                	<div class="w-full grid grid-cols-6 gap-2 py-2">
					                		<p x-text="ticket.type" class=""></p>
					                		<p x-text="ticket.access_type"></p>
					                		<p x-text="ticket.price"></p>
					                		<p x-text="ticket.total_seat" class="text-center"></p>
					                		<p x-text="ticket.available_seat" class="text-center"></p>
					                		<p class="flex justify-start gap-4">
					                			<span class="text-blue-600 underline cursor-pointer" @click="viewTicket(ticket, event)">View</span>
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

		<div class="text-center hidden">
	        <button class="text-black bg-white" type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" id="right-drawer-button" x-ref="sideBarButton">
	         Show right drawer
	         </button>
	    </div>

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
			            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Presentation</button>
			        </li>
			       {{--  <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Edit</button>
			        </li> --}}
			        <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-styled-tab" data-tabs-target="#styled-settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Attendance</button>
			        </li>
			    </ul>
			</div>
			<div id="default-styled-tab-content">
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
            		<template x-if="typeLength == 10">
            			<div>
            				{{-- <h2>This is early bird page</h2> --}}
            				<x-tickets.early-bird></x-tickets.early-bird>
            			</div>
            		</template>		
            		<template x-if="typeLength == 17">
            			<div>
            				<x-tickets.ga></x-tickets.ga>
            				{{-- <h2>This is General admission page</h2> --}}
            			</div>
            		</template>
            		<template x-if="typeLength == 3">
            			<div>
            				<x-tickets.vip>	</x-tickets.vip>
            				{{-- <h2>This is VIP page</h2> --}}
            			</div>
            		</template>		
			    </div>
			    {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
			        Ticket form would be here
			    </div> --}}
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-settings" role="tabpanel" aria-labelledby="settings-tab">
			       <x-attendance></x-attendance>
			    </div>
			</div>
	        </div>
	    </div>
	</div>

@endsection

