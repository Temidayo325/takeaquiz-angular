<form x-data='{		spinner: false,
					errorMessage: null,
					createTicketButtonText: "Save edit",
					data: { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "", location: "", tags: "" }, 
					submitForm(){
						$refs.createTicketButton.setAttribute("disabled", "")
						this.spinner = true
						this.createTicketButtonText = "Saving edit ..."
						this.toast("Saving edit ...", "#fff", "blue")
						let formdata = new FormData($refs.form)
						formdata.append("tags", this.data.tags);
						axios.post("/promoter/dashboard/events/create", formdata)
						.then( (response) => {
							if(!response.data.error)
							{
								this.data = { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "", location: "", tags: "", "social_media_handle": "", "event_type" : "", "duration": "", "audience": "", "dress_code": "" }
								this.toast("Event created Succesfully", "#fff", "green")
								location.href = "/promoter/dashboard/tickets/create"
							}
							$refs.createTicketButton.removeAttribute("disabled")
							this.spinner = false
							this.createTicketButtonText = "Create event"
						})
						.catch( (error) => {
							this.spinner = false
							this.createTicketButtonText = "Create ticket"
							$refs.createTicketButton.removeAttribute("disabled")
							this.toast(error.response.data.message, "#fff", "#DB162F")
							this.errorMessage = error.response.data.message
						})
					},
					toast(text, color, background)
					{
    					Toastify({
						  text: text, 
						  style: {
						    background: background,
						    color: color
						  }
						}).showToast();
    				},
				}' 
				action="" 
				method="post" 
				class="bg-white mx-4 shadow-lg rounded-lg border-2 border-gray-300 p-3 mx-auto mt-3 overflow-hidden text-purple-1000 grid gap-3 pb-6 md:w-3/6 md:mx-auto md:px-12" x-ref="form">
	        		<h2 class="font-display font-normal tracking-wider text-center text-purple-1000 text-lg py-3">Create a new event</h2>
					@csrf
					<template x-if="errorMessage != null">
			       		<p x-text="errorMessage" class="text-purple-1000 p-2 text-sm leading-7 bg-red-300"></p>
			       	</template>
					<div class="mt-4">
						<label for="name" class="font-bold text-sm block">Name of the event <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Insert the name of the event here.</p>
						<input type="text" name="name" id="name" required minLength="5" x-model="data.name" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>
					<div class="mt-4">
						<label for="state" class="font-bold text-sm block mb-1">State of the event <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Provide the state or region where the event will take place.</p>
						<select name="state" id="state" required x-model="data.state" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
							<option value="all">All states</option>
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
					<div class="mt-4">
						<label for="event_date" class="font-bold text-sm block mb-1">Date of the event <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1"></p>
						<input type="date" name="event_date" id="event_date" required x-model="data.event_date" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>
					<div class="mt-4">
						<label for="starting_time" class="font-bold text-sm block mb-1">Time of the event <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<input type="time" name="starting_time" id="starting_time" required x-model="data.starting_time" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full" />
					</div>

					<div class="mt-4">
						<label for="duration" class="font-bold text-sm block mb-1">Duration of event <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Add the estimated duration of the event or its end time. Example: 19:00 – 01:00</p>
						<input type="text" name="duration" id="duration" required x-model="data.duration" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="location" class="font-bold text-sm block mb-1">Location <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Provide a succint and clear direction to the venue using popular landmarks for easy comprehension. Example: XYZ Hall, near City Mall, opposite ABC Restaurant</p>
						<textarea name="location" id="location" required x-model="data.location" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full h-48 text-sm leading-7 "></textarea>
					</div>
					<div class="mt-4">
						<label for="promotional_copy" class="font-bold text-sm">Promotional copy <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Hint: Give a quick gist of what to expect from the event including performing artists. Example: Get ready for an unforgettable night featuring DJ Spinall, Alcohol, and vibes that’ll keep you on your feet!</p>
						<textarea name="promotional_copy" id="promotional_copy" maxlength="2000" x-model="data.promotional_copy" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full h-48 text-sm leading-7 "></textarea>
					</div>
					<div class="mt-4">
						<label for="tags" class="font-bold text-sm">Event tags <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Add some tags to help in search like you'll do in twitter, separate using a comma.</p>
						<input type="text" name="tags" id="tags" required x-model="data.tags" placeholder="blockparty, party, shayo, badman, vibesAndChill" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full placeholder:text-gray-200">
					</div>
					<div class="mt-4">
						<label for="flier" class="font-bold text-sm block mb-1">Event flier <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Attach or upload an image file of the event flier.</p>
						<input type="file" name="flier" id="flier" required x-ref="flier" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="audience" class="font-bold text-sm block mb-1">Audience <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Specify the audience the event is geared towards (e.g., All Ages, Adults Only, Families). Example: Adults Only.</p>
						<select name="audience" id="audience" required="" x-model="data.audience" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
							<option value="All ages">All ages</option>
							<option value="Adult only">Adult only</option>
							<option value="Families">Family friendly</option>
						</select>
						{{-- <input type="text" name="audience" id="audience" required x-model="data.audience" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full"> --}}
					</div>

					<div class="mt-4">
						<label for="dress_code" class="font-bold text-sm block mb-1">Dress Code </label>
						<p class="text-sm text-greyish py-1">Mention if there’s a specific dress code or theme for the event to help attendees prepare. Example: All-white party attire.</p>
						<input type="text" name="dress_code" id="dress_code" required x-model="data.dress_code" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<div class="mt-4">
						<label for="contact_information" class="font-bold text-sm block mb-1">Contact Information <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Provide contact details for inquiries, support, or assistance, separating each phone number or social media link with a comma (,). Example: info@midnightvibes.com , +234 123 456 789, https:\\www.x.com/myeventpage</p>
						<input type="text" name="contact_information" id="contact_information" required x-model="data.contact_information" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
					</div>

					<button class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 rounded-lg shadow-md md:shadow-sm disabled:bg-gray-400 disabled:text-purple-1000 disabled:shadow-none md:w-2/6 md:mx-auto" type="submit" @click.prevent="submitForm()" x-ref="createTicketButton">
						<svg x-show="spinner" aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>
						<span x-text="createTicketButtonText"></span>
					</button>
				</form>