@extends('layouts.admin')

@section('title', 'Edit your tickets')

@section('content')
	<div x-data='{ events: @json($events),
					user: @json($user),
					ticket: { "price": "", "total_seat": "", "ticket_type": "VIP", "type_copy" : "", "access_type": ""},
					chosenEvent: null,
                    componentKey: Date.now(),
					errorMessage: null,
					spinner: false,
                    ticket_id: 0,
                    ticketIndex: 0,
					chosenEventTickets: null,
                    editTicketStatus: false,
					init(){
						
					},
    				addEvent(event){
    					this.ticket.event_id = event.id
    					this.chosenEvent = event
    					this.chosenEventTickets = event.tickets
                       
                        this.editTicketStatus = false
    				},
    				toast(text, color, background){
    					Toastify({
						  text: text, 
						  style: {
						    background: background,
						    color: color
						  }
						}).showToast();
    				},
                    findNReplace(pin, haystack, replacement)
                    {
                        let index = haystack.findIndex(pin)
                        haystack.splice(index, 1, replacement)
                    },
                    changeEventStatus(ticket)
                    {
                        try {
                            axios.post("/promoter/dashboard/ticket/status", {id: ticket.id})
                            .then(response => {
                                let updatedTicket = ticket
                                updatedTicket.status = ( ticket.status == "DRAFT" ) ? "PUBLISHED" : "DRAFT"
                                this.toast("Ticket status updated Succesfully")
                            })
                            .catch((error) => {
                                this.toast("Error updating ticket status")
                            })
                        } catch (error) {
                            this.toast("Error updating ticket status")
                        }
                    },
                    showEditForm(ticket, index)
                    {
                        $refs.editTicketTab.dispatchEvent(new Event("click"))
                        this.ticketIndex = index
                        this.componentKey = Date.now()
                        $nextTick(() => { 
                            this.editTicketStatus = true 
                            this.ticket_id = ticket.id
                            this.ticket = { ...ticket }
                        })                       
                        
                    },
	}' class="px-4 md:px-12 py-4 font-body text-purple-1000" >
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">Tap on an event to check out any tickets already set up (if there’s any cruise pass chilling there), and add more sharp-sharp if needed. As per the Oga wey you be!</p>
			</div>
			<img src="{{asset('/images/create-ticket.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="py-4 grid gap-3">
			<h3 class="text-md font-bold mt-6">Upcoming events and tickets</h3>
			<p class="leading-7 text-sm md:hidden">Click on an event to check out any tickets already set up (if there’s any chilling there), and add more A-S-A-P if needed. As per the Oga wey you be!</p>
		</div>
		<div class="flex justify-center items-center md:mt-8">
			<template x-if="events.data.length <= 0">
				<h3 class="text-sm leading-7 my-6">You do not any event you can create a ticket for, <a href="/promoter/dashboard/events/create">Click here</a>  to create an event</h3>
			</template>
		</div>
		<div class="pb-20">
			<ul class="grid gap-10 md:grid-cols-3 md:gap-12">
				<template x-for="(event, index) in events.data" :key="event.id">
					<li class="hover:shadow-2xl duration-700 hover:border hover:border-gray-400 p-3 bg-gray-100 md:bg-white md:border md:border-gray-200 shadow-md md:shadow-sm cursor-pointer" title="Click the event to create tickets for it">
						<div class="grid gap-2">
							<div class="flex justify-between items-center">
								<p x-text="new Date().toDateString(event.event_date)" class=""></p>
								<template x-if="event.isPremium == 1">
								    <span class="text-red-1000 text-center text-2xl font-bold ">&#9824;</span>
								</template>
							</div>
							<img :src="`{{ asset('./images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
							<div>
								<h2 x-text="event.name" class="text-xl font-display tracking-wider font-bold"></h2>
								<div class="flex justify-start items-center gap-5 mt-1 text-md">
									<p class="flex justify-start items-center gap-1">
										<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" /></svg>
										<span x-text="event.state"></span>
									</p>
									<p class="flex justify-start items-center gap-1">
										<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
										<span x-text="event.starting_time"></span>
									</p>
								</div>
								<p class="mt-2">
									<svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
									<span x-text="event.location" class="text-md"></span>
								</p>
								<button  @click="addEvent(event, index)" 
										data-drawer-target="drawer-right-example" 			data-drawer-show="drawer-right-example" data-drawer-placement="right" 
										aria-controls="drawer-right-example" 
										id="right-drawer-button"
										class="mt-5 bg-yellow-200 text-gray-900 hover:bg-yellow-400 hover:shadow-md hover:text-gray-950 w-full py-2">Modify tickets
								</button>
							</div>
						</div>
					</li>
				</template>
			</ul>
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
			            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" x-ref="eventTicketTab">Tickets</button>
			        </li>
			       {{--  <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Edit</button>
			        </li> --}}
			        <li class="me-2" role="presentation">
			            <button x-show="editTicketStatus" 
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                        id="settings-styled-tab" 
                        data-tabs-target="#styled-settings" 
                        type="button" 
                        role="tab" 
                        x-ref="editTicketTab"
                        aria-controls="settings" 
                        aria-selected="false" 
                        data-tooltip-target="tooltip-no-arrow">Edit ticket</button>
			            <div id="tooltip-no-arrow" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
						    Click to display ticket form 
						</div>
			        </li>
			    </ul>
			</div>
			<div id="default-styled-tab-content">
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tracking-wider" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
            		<template x-if="chosenEventTickets != null && chosenEventTickets.length > 0" class="grid gap-20">
			       		<template x-for="(ticket, index) in chosenEventTickets" :key="ticket.id">
			       			<div>
								<div >
									<div class="bg-white text-purple-1000 px-4 py-8 pb-5 rounded w-48 md:w-64 mt-6 text-center border border-gray-200 shadow-md hover:shadow-lg mx-auto">
                                        <p class="text-center pb-6 " x-text="ticket.name"></p>
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
												<p class="text-greyish text-sm">Promoter</p>
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
										<h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.name"></span></h2>
										<p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
									</div>
                                    <div class="mt-3">
                                        <template x-if="ticket.status == 'DRAFT'">
                                            <button @click="changeEventStatus(ticket)" class="py-2 w-full bg-yellow-300 text-purple-1000 shadow-md hover:bg-yellow-500 hover:text-purple-100" title="Click this button to publish this event">Publish ticket</button>
                                        </template>
                                        <template x-if="ticket.status == 'PUBLISHED'">
                                            <button @click="changeEventStatus(ticket)" class="py-3 w-full bg-red-1000 text-purple-100 shadow-md hover:bg-red-800 hover:text-purple-200" title="Click this button to make this event a draft">Unpublish Ticket</button>
                                        </template>
                                        <button @click="showEditForm(ticket, index)" class="underline underline-offset-4 text-center py-4 w-full text-sm">Edit ticket</button>
                                    </div>
								</div>
			       			</div>
			       		</template>
			       	</template>
			       	<template x-if="chosenEventTickets != null && chosenEventTickets.length <= 0">
			       		<p class="text-sm leading-7 text-purple-1000 font-body">You have not created tickets for this event yet, go to the to create tickets for this event</p>
			       	</template>	
			    </div>
			    {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
			        Ticket form would be here
			    </div> --}}
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 overflow-x-hidden md:px-8" id="styled-settings" role="tabpanel" aria-labelledby="settings-tab">
			       	<form action="" x-data='{
                    createTicketButtonText: "Edit ticket",
                    editTicket(){
                        console.table(this.ticket)
						this.createTicketButtonText = "Editing ticket ..."
						this.toast("Editing ticket .... ", "#fff", "#1d1128")
						$refs.createTicketButton.setAttribute("disabled", "")
						this.spinner = true
						axios.post("/promoter/dashboard/ticket/modify", { ...this.ticket, id: this.ticket_id })
							.then( ( response ) => {
								$refs.eventTicketTab.dispatchEvent(new Event("click"))
								this.errorMessage = null
								this.editTicketStatus = false
                                
                                let index = this.chosenEventTickets.findIndex(t => t.id === this.ticket.id)
                                this.chosenEventTickets.splice(index, 1, response.data.ticket)

								this.spinner = false
								this.createTicketButtonText = "Edit ticket"
								this.toast("Ticket edited ", "#fff", "green")
								$refs.createTicketButton.removeAttribute("disabled")
                                this.ticket = { "id": this.ticket.id, "price": "", "total_seat": "", "ticket_type": "VIP", "type_copy" : "", "access_type": "Purchase"}
							})
							.catch( ( error ) => {
                                console.log(error)
								this.spinner = false
								this.createTicketButtonText = "Edit ticket"
								$refs.createTicketButton.removeAttribute("disabled")
								this.toast(error.data.response.message, "#fff", "#DB162F")
								this.errorMessage = error.data.response.message
							})
					} }' method="post" @submit.prevent="editTicket()" class="w-full grid gap-6 my-5 mx-auto font-body tracking-wide text-purple-1000 overflow-x-hidden pb-8" :key="componentKey">
			       		<template x-if="chosenEvent != null">
			       			<img :src="`{{ asset('./images') }}/${chosenEvent.flier}`" alt="Image depicting the event" class="w-full h-auto md:w-full mb-5">
			       		</template>
			       		<template x-if="errorMessage != null">
			       			<p x-text="errorMessage" class="text-gray-100 p-2 text-sm leading-7 bg-red-300 mb-3"></p>
			       		</template>

			       		<div>
							<label for="ticket_type" class="font-bold text-md">Ticket name <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
							<p class="text-sm text-gray-700 ">Provide a name for your ticket. E.g Diamond </p>
                            <p >Initial input: <span x-text="ticket.name"></span></p>
							<input type="text" name="name" id="name" x-model="ticket.name" required class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
						</div>
			       		
						<div>
							<label for="total_seat" class="font-bold text-sm">Ticket Quantity <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
							<p class="text-sm text-gray-700 ">Provide the total number of tickets available for sale</p>
                            <p >Initial input: <span x-text="ticket.total_seat"></span></p>
							<input type="tel" name="total_seat" id="total_seat" x-model="ticket.total_seat" required class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
						</div>

						<div>
							<label for="access_type" class="font-bold text-sm">Ticket access type <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
							<p class="text-sm text-gray-700 ">State wether the ticket is free or not</p>
                            <p >Initial input: <span x-text="ticket.access_type"></span></p>
							<select x-model="ticket.access_type" required class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
								<option >Free</option>
								<option >Purchase</option>
							</select>
						</div>
                        
						<div class="">
							<label for="price" class="font-bold text-sm">Price <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
							<p class="text-sm text-gray-700 ">State ticket price. In case the ticket is free, kindly input 0</p>
                            <p >Initial input: <span x-text="ticket.price"></span></p>
							<input type="tel" name="price" id="price" x-model="ticket.price" required class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
						</div>
						
						<div>
							<label for="type_copy" class="font-bold text-sm">Short ticket copy <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
							<p class="text-greyish text-sm text-left">Highlight Ticket Perks and Promises</p>
                            <p >Initial input: <span x-text="ticket.type_copy"></span></p>
							<textarea name="type_copy" id="type_copy" x-model="ticket.type_copy" required class="w-48 min-h-48 text-sm leading-7 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full"></textarea>
						</div>
						<div class="flex justify-center items-center mt-3">
							<button class="bg-red-1000 text-gray-200 px-10 py-3" x-ref="createTicketButton">
								<svg x-show="spinner" aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>
								<span x-text="createTicketButtonText"></span></button>
						</div>
					</form>
			    </div>
			</div>
	        </div>
	    </div>
		
	</div>
@endsection

