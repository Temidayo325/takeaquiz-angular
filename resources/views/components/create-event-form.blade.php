<div class="flex justify-between items-center my-4">
	<h1 class="text-lg font-bold">Event dashboard</h1>
	<a href="/promoter/dashboard/events" class="px-6 py-2 bg-gray-950 text-gray-300">View all events</a>
</div>
<form action="" 
		method="post"
		@submit.prevent="submitForm()" 
		x-data='{ data: { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "", location: "" }, 
				submitForm(){
					axios.post("/promoter/dashboard/events/create", this.data)
					.then( ( response ) => {
						console.log(response)
						this.data = { name: "", state: "", event_date: "", starting_time: "", promotional_copy: "", coordinate: "" }
					})
					.catch(error => console.log(error))
				}}'
		class="mx-auto md:w-6/12 border border-gray-400 shadow-md px-20 py-5 grid gap-3">
				@csrf
		<div class="my-2">
			<label for="event_name" class="font-bold text-gray-950">Name of the event</label>
			<p class="text-gray-600 text-sm ">Hint: Make it as awesome as possible</p>
			<input type="text" name="event_name" id="event_name" required="required" minLength="5" x-model="data.name" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
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
			<label for="location">Event location</label>
			<input type="text" name="location" id="location" required x-model="data.location">
		</div>
		<div class="">
			<label for="flier">Event flier</label>
			<input type="file" name="flier" id="flier" required x-ref="flier">
		</div>
		<div class="">
			<label for="promotional_copy">Promotional copy</label>
			<p>Hint: Provide a summary of the expected outcome </p>
			{{-- <input type="text" name="promotional_copy" id="promotional_copy" maxlength="2000" x-model="data.promotional_copy"> --}}
			<textarea name="promotional_copy" id="promotional_copy" maxlength="2000" x-model="data.promotional_copy"></textarea>
		</div>
		<div class="">
			<label for="coordinate">Coordinate</label>
			<input type="text" name="coordinate" id="coordinate" required x-model="data.coordinate">
		</div>

		<button type="submit" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold mx-auto shadow-lg hover:bg-gray-800 hover:text-gray-500 my-4 mx-auto ">Save changes</button>
</form>