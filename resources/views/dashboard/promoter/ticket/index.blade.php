@extends('layouts.admin')

@section('title', 'Ticket dashboard')

@section('content')
	<div x-data='{ events: @json($events),
						open: false,
						user: JSON.parse(localStorage.getItem("user")),
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
							this.chosenEvent.user = this.user
							this.chosenAttendance = ticket.attendance
							this.viewToggle = true
							this.editToggle = false
							this.typeLength = parseInt(ticket.type.trim().length)
							sessionStorage.setItem("ticket", JSON.stringify(ticket));
							$refs.sideBarButton.dispatchEvent(new Event("click"))
						} 
		}' class="md:px-10 font-body text-purple-1000 px-4 w-full py-6">
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">Tap on an event to check out any tickets already set up (if there’s any cruise pass chilling there), and add more sharp-sharp if needed. As per the Oga wey you be!</p>
				<a href="" class="bg-red-1000 text-gray-100 px-7 py-3">Create new ticket</a>
			</div>
			<img src="{{asset('/images/create-ticket.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<h2 class="font-bold md:mt-12 mt-6 text-md md:text-lg">Events and their corresponding tickets</h2>
		<ul class="md:mt-8 mt-6 grid gap-10">
			<template x-if="events.data.length <= 0">
				<p class="text-center my-6">You do not have an event you can create a ticket for, kindly <a href="/promoter/dashboard/events/create">click here to create an event</a>  to get started</p>
			</template>
			<template x-if="events.data.length > 0">
				<template  x-for='event in events.data' :key="event.id">
						<li class="hover:shadow-2xl duration-700 hover:border hover:border-gray-400 p-3 bg-white md:bg-white md:border md:border-gray-200 shadow-md md:shadow-sm cursor-pointer">
							<div class="grid gap-2">
								<div class="flex justify-between items-center">
									<p x-text="new Date().toDateString(event.event_date)" class=""></p>
									<template x-if="event.isPremium == 1">
									    <span class="text-red-1000 text-center text-2xl font-bold ">&#9824;</span>
									</template>
								</div>
								<img :src="`{{ asset('./images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
								<div>
									<h2 x-text="event.name" class="text-xl font-display tracking-wider"></h2>
									<div class="flex justify-start items-center gap-5 mt-1 text-sm">
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
							<template x-if="event.tickets.length == 0">
	                			<p class="col-span-full text-center py-2">There are no tickets for this event yet, proceed to the Ticket section to create a one.</p>
	                		</template>
	                		<template x-if="event.tickets.length > 0">
			                	<div class="w-full">
			                		<div class="md:grid hidden md:font-bold text-sm w-full md:grid-cols-6 gap-2 md:gap-4 md:mt-6">
				                		<h4>Ticket type</h4>
				                		<h4>Ticket Access</h4>
				                		<h4>Ticket price</h4>
				                		<h4 class="text-center">Expected odogwus</h4>
				                		<h4 class="text-center">Yet-to-annouce Odogwus</h4>
				                		<h4>Actions</h4>
				                	</div>
				                	<template x-for="ticket in event.tickets">
					                	<div class="w-full md:grid md:grid-cols-6 gap-2 py-2">
					                		<p x-text="ticket.type + ' ticket' " class="text-center font-display py-2 md:py-0 tracking-wider"></p>
					                		<p class="text-left md:text-left">
					                			<span class="md:hidden text-sm py-2">Ticket Access</span>
					                			<span  x-text="ticket.access_type" class="text-sm mx-4 md:mx-0 font-bold"></span>
					                		</p>
					                		<p class="text-left md:text-left">
					                			<span class="md:hidden text-sm py-2">Ticket Price</span>
					                			<span  x-text="ticket.price" class="text-sm mx-4 md:mx-0 font-bold"></span>
					                		</p>
					                		<p class="text-left md:text-center">
					                			<span class="md:hidden text-sm py-2">Expected odogwus</span>
					                			<span  x-text="ticket.total_seat" class="text-sm mx-4 md:mx-0 font-bold"></span>
					                		</p>
					                		<p class="text-left md:text-center">
					                			<span class="md:hidden text-sm py-2">Confirmed odogwus</span>
					                			<span  x-text="ticket.available_seat" class="text-sm mx-4 md:mx-0 font-bold"></span>
					                		</p>

					                		<p class="flex justify-center gap-4 mt-2">
					                			<span class="text-blue-600 underline cursor-pointer" @click="viewTicket(ticket, event)">View</span>
					                			<button class="text-red-600 underline cursor-pointer border-none" @click="deleteTicket(ticket.id)">Delete</button>
					                		</p>
					                	</div>
					                </template>
			                	</div>
			                </template> 
						</li>
				</template>
			</template>			
		</ul>
		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-4">
			<template x-if="events.prev_cursor != null">
				<button class="px-8 py-2 bg-lightpurple text-purple-1000" @click="fetchData(events.prev_cursor)">Prev</button>
			</template>
			<template x-if="events.next_cursor != null">
				<button class="px-8 py-2 bg-lightpurple text-purple-1000" @click="fetchData(events.next_cursor)">Next</button>
			</template>
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
			            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Ticket</button>
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
            			<x-tickets.early-bird></x-tickets.early-bird>
            		</template>		
            		<template x-if="typeLength == 17">
            			<x-tickets.ga></x-tickets.ga>
            		</template>
            		<template x-if="typeLength == 3">
            			<x-tickets.vip>	</x-tickets.vip>
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

