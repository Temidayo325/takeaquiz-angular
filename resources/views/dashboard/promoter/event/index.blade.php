@extends('layouts.admin')

@section('title', 'View all Scheduled events')

@section('content')
	<div 	class="text-purple-1000 pb-32 px-4 md:px-10 md:mx-auto min-h-screen font-body" 
			x-data='{   events: @json($events),
						user: @json($user),
						chosenEvent: null,
						data: { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "", location: "", tags: "" }, 
						spinner: false,
						errorMessage: null,
						createTicketButtonText: "Save edit",
						init(){
							{{-- console.log(this.events) --}}
						},
						submitForm(){
							$refs.createTicketButton.setAttribute("disabled", "")
							this.spinner = true
							this.createTicketButtonText = "Saving edit ..."
							this.toast("Saving edit ...", "#fff", "blue")
							let formdata = new FormData($refs.form)
							if(!this.data.flier)
							{
								formdata.append("event_flier", $refs.flier.files[0]);
							}
							formdata.append("id", this.data.id);
							formdata.append("tags", this.data.tags);
							axios.post("/promoter/dashboard/events/create", formdata)
							.then( (response) => {
								$refs.createTicketButton.removeAttribute("disabled")
								this.spinner = true
								this.createTicketButtonText = "Save edit"
								this.toast("Edit saved Succesfully", "#fff", "green")
								this.data = { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "", location: "", tags: "" }
							})
							.catch( (error) => {
								this.spinner = false
								this.createTicketButtonText = "Create ticket"
								$refs.createTicketButton.removeAttribute("disabled")
								this.toast(error.response.data.message, "#fff", "#DB162F")
								this.errorMessage = error.response.data.message
							})
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
						editEvent(event)
						{
	    					this.chosenEvent = event
	    					sessionStorage.setItem("event_id", event.id)
	    					this.data = event
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
	    				findNReplace(pin, haystack, replacement)
	    				{
	    					let index = haystack.findIndex(pin)
	    					haystack.splice(index, 1, replacement)
	    				},
	    				changeEventStatus(event)
	    				{
	    					try {
				                axios.post("/promoter/dashboard/event/status", {id: event.id})
				                .then(response => {
				                	let updatedEvent = event
				                	updatedEvent.status = ( event.status == "Draft" ) ? "Published" : "Draft"
				                	{{-- this.findNReplace(event, this.events.data, updatedEvent) --}}
				                	this.toast("Event status updated Succesfully")
				            	})
				                .catch((error) => {
				                	this.toast("Error updating event status")
				                	console.log(error)
				            	})
				            } catch (error) {
				            	this.toast("Error updating event status")
				                console.error(error)
				            }
	    				}
		}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">View all your events, tap on the edit button on each event card to edit the details of the events as required</p>
				<a href="/promoter/dashboard/events/create" class="px-4 py-2 font-bold md:font-normal bg-red-1000 text-gray-200">Create event</a>
			</div>
			<img src="{{asset('/images/party.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="flex justify-between items-center py-6 md:pt-12 md:pb-4">
			<h1 class="font-bold text-md md:text-lg">My Events</h1>
			<a href="/promoter/dashboard/events/create" class="md:hidden px-4 py-2 text-red-1000 font-bold md:font-normal md:bg-red-1000 md:text-gray-200">Create event</a>
		</div>

		<div class="text-sm text-purple-1000 w-full text-sm text-left rtl:text-right dark:text-gray-400 mt-6 md:mt-8">
			<ul class="grid gap-10 md:grid-cols-4 md:gap-12">
				<template x-for="event in events.data" :key="event.id">
					<li class="hover:shadow-2xl duration-700 hover:border hover:border-gray-400 p-3 bg-gray-100 md:bg-white md:border md:border-gray-200 shadow-md md:shadow-sm relative " >
						<div class="grid gap-2">
							<div class="flex justify-between items-center">
								<p x-text="new Date().toDateString(event.event_date)" class=""></p>
								<template x-if="event.isPremium == 1">
								    <span class="text-red-1000 text-center text-2xl font-bold ">&#9824;</span>
								</template>
							</div>
							<img :src="`{{ asset('/images') }}/${event.flier}`" alt="Image depicting the game" class="w-full h-auto md:w-64 ">
							<div>
								<h2 x-text="event.name" class="text-xl font-display tracking-wider"></h2>
								<div class="flex justify-start items-center gap-5 mt-1">
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
									<span x-text="event.location" class="text-sm"></span>
								</p>
							</div>
						</div>
						<p class="mt-2 flex justify-between gap-2 items-baseline">
		            		<template x-if="Date.parse(event.event_date) > Date.now()">
							    <span class="text-green-600 font-bold">Upcoming</span>
							</template>
							<template x-if="Date.now() > Date.parse(event.event_date)">
							    <span class="text-red-600 font-bold">Done & Dusted</span>
							</template>
							<span x-text="event.status" :class="{ 'text-blue-800': event.status == 'Draft', 'text-green-600': event.status == 'Published' }" class="font-bold"></span>
							<button class="cursor-pointer text-red-1000 underline-offset-4 underline" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" id="right-drawer-button" @click="editEvent(event)" title="Click to edit the details of the event">Edit</button>
		            	</p>
		            	<div class="mt-3">
		            		<template x-if="event.status == 'Draft'">
		            			<button @click="changeEventStatus(event)" class="py-2 w-full bg-yellow-300 text-purple-1000 shadow-md hover:bg-yellow-500 hover:text-purple-100" title="Click this button to publish this event">Publish event</button>
		            		</template>
		            		<template x-if="event.status == 'Published'">
		            			<button @click="changeEventStatus(event)" class="py-3 w-full bg-red-1000 text-purple-100 shadow-md hover:bg-red-800 hover:text-purple-200" title="Click this button to make this event a draft">Remove event</button>
		            		</template>
		            	</div>
		                
					</li>
				</template>
			</ul>
			<template x-if="events.data.length <= 0">
				<h2 class="text-center my-6 font-bold text-lg text-purple-1000 ">You have not created any event yet. </h2>
			</template>
		</div>
		
		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-4">
			<template x-if="events.data.prev_cursor">
				<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.prev_cursor)">Prev</button>
			</template>
			<template x-if="events.data.next_cursor">
				<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(events.next_cursor)">Next</button>
			</template>
		</div>

		<!-- drawer component -->
	    <div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
	        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
	            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
	            <span class="sr-only">Close menu</span>
	        </button>
	        <div class="py-4 overflow-y-auto text-black">
	        	<form action="" method="post" class="bg-white p-3 mx-auto mt-3 overflow-hidden text-purple-1000 grid gap-3" x-ref="form" @submit.prevent="submit">
	        		<h2 class="font-display font-normal text-center text-purple-1000 text-lg py-3">Create a new event</h2>
					@csrf
					<template x-if="errorMessage != null">
			       		<p x-text="errorMessage" class="text-purple-1000 p-2 text-sm leading-7 bg-red-300"></p>
			       		</template>
					<div class="">
						<label for="name" class="font-bold text-sm block mb-1">Name of the event</label>
						<p class="text-sm text-greyish py-1">Hint: Make the name sharp</p>
						<input type="text" name="name" id="name" required minLength="5" x-model="data.name" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>
					<div class="">
						<label for="state" class="font-bold text-sm block mb-1">State of the event</label>
						<select name="state" id="state" required x-model="data.state" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
							<option value="abia">Abia</option>
							<option value="abuja">Abuja</option>
							<option value="edo">Edo</option>
							<option value="ekiti">Ekiti</option>
							<option value="kebbi">Kebbi</option>
							<option value="kogi">Kogi</option>
							<option value="kwara">Kwara</option>
							<option value="lagos">Lagos</option>
							<option value="ondo">Ondo</option>
							<option value="osun">Osun</option>
							<option value="rivers">Rivers</option>
							<option value="sokoto">Sokoto</option>
						</select>
					</div>
					<div class="">
						<label for="event_date" class="font-bold text-sm block mb-1">Date of the event</label>
						<input type="date" name="event_date" id="event_date" required x-model="data.event_date" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>
					<div class="">
						<label for="starting_time" class="font-bold text-sm block mb-1">Time of the event</label>
						<input type="time" name="starting_time" id="starting_time" required x-model="data.starting_time" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>
					<div class="">
						<label for="location" class="font-bold text-sm block mb-1">Location</label>
						<p class="text-sm text-greyish py-1">Provide a succint and clear direction to the venue using popular landmarks for easy comprehension</p>
						<input type="text" name="location" id="location" required x-model="data.location" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>
					<div class="">
						<label for="promotional_copy" class="font-bold text-sm">Promotional copy</label>
						<p class="text-sm text-greyish py-1">Hint: Give a quick gist of what to expect from this including artists performing, ballers present etc</p>
						<textarea name="promotional_copy" id="promotional_copy" maxlength="2000" x-model="data.promotional_copy" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full h-48 text-sm leading-7 "></textarea>
					</div>
					<div class="">
						<label for="tags" class="font-bold text-sm">Event tags</label>
						<p class="text-sm text-greyish py-1">Add some tags to help in search like you'll do in twitter, separate using a comma.</p>
						<input type="text" name="tags" id="tags" required x-model="data.tags" placeholder="blockparty, party, shayo, badman, vibesAndChill" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full placeholder:text-gray-200">
					</div>
					<div class="">
						<label for="flier" class="font-bold text-sm block mb-1">Event flier</label>
						<input type="file" name="flier" id="flier" required x-ref="flier" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="">
						<label for="coordinate" class="font-bold text-sm block mb-1">Coordinate</label>
						<input type="text" name="coordinate" id="coordinate" required x-model="data.coordinate" class="w-48 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="duration" class="font-bold text-sm block mb-1">Duration of event</label>
						<input type="text" name="duration" id="duration" required x-model="data.duration" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="audience" class="font-bold text-sm block mb-1">Audience</label>
						<input type="text" name="audience" id="audience" required x-model="data.audience" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="dress_code" class="font-bold text-sm block mb-1">Dress Code</label>
						<input type="text" name="dress_code" id="dress_code" required x-model="data.dress_code" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="contact_information" class="font-bold text-sm block mb-1">Contact Information</label>
						<input type="text" name="contact_information" id="contact_information" required x-model="data.contact_information" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<button class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 hover:bg-red-900 duration-500" type="submit" @click.prevent="submitForm()" x-ref="createTicketButton">
						<svg x-show="spinner" aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>
						<span x-text="createTicketButtonText"></span>
					</button>
				</form>
				<template x-if="chosenEvent != null && chosenEvent.isPremium === 1">
					<x-event.add-premium-media ></x-event.add-premium-media>
				</template>
				
	        </div>
	    </div>
	</div>

@endsection