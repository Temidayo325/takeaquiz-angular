@props(['user'])
<section class="py-4 text-purple-1000">
	<h2 class="text-xl mb-4 font-bold text-center tracking-wider">Plug form</h2>
	<form action="/plugs"
		x-data='{plug: @json($user), 
			placeholder: {flier: null, service: null, service_summary: null, tags: null, address: null, state: null, social_media_links: null, travel: null},
			init(){

				if(this.plug != null)
				{
					this.placeholder = this.plug
				}
		}}',
		method="POST" 
		enctype="multipart/form-data"
		class="grid gap-4">
		@csrf
		<div class="mt-4" >
			<label for="flier" class="font-bold text-sm block mb-1">Flyer <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Attach or upload an image file promoting your service. The image file should be less than 2MB</p>
			<input x-show="plug == null" accept="image/png, image/jpeg" type="file" name="flier" id="flier" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600" />
			<template x-if="plug != null ">
				<img :src="`{{ asset('/images') }}/${plug.flier}`" alt="flier of the plug" class="w-full h-56 mt-2">
			</template>
			<x-input-error :messages="$errors->get('flier')" class="mt-2" />
		</div>
		<div class="mt-4">
			<label for="service" class="font-bold text-sm">Service rendered <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">This best describes the service you offer. Remeber to use popular name to improve your visibility to people that need you.</p>
			<input type="text" name="service" id="service" placeholder="Example. DJ" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" autofocus x-model="placeholder.service" :disabled="plug != null && placeholder.service != null" />			
			<x-input-error :messages="$errors->get('service')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="service_summary" class="font-bold text-sm">Summary of service rendered <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Hint: Give a quick summary of your service and package!</p>
			<textarea name="service_summary" id="service_summary" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.service_summary" :disabled="plug != null && placeholder.service_summary != null"></textarea>
			<x-input-error :messages="$errors->get('service_summary')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="address" class="font-bold text-sm">Contact address <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Your physical outfit address</p>
			<input type="text" name="address" id="address" placeholder="Example. No 3 Yagi Village, Lagos state" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.address" :disabled="plug != null && placeholder.address != null">
			{{-- <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" required  autocomplete="name" /> --}}
			<x-input-error :messages="$errors->get('address')" class="mt-2" />
		</div>

		<div class="">
			<label for="state" class="font-bold text-sm block">State <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<select name="state" id="state" class="border border-purple-100 focus:outline-none focus:ring-0 focus:border-none focus:shadow-lg focus:border focus:border-gray-100 mt-2 w-full md:w-5/6 md:border-gray-300" x-model="placeholder.state" :disabled="plug != null && placeholder.state != null">
				<option value="" disabled>Select desired state</option>
				<option value="Abuja">Abuja</option>
				<option value="Kwara">Kwara</option>
				<option value="Lagos">Lagos</option>
				<option value="Osun">Osun</option>
			</select>
			<x-input-error :messages="$errors->get('state')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="social_media_links" class="font-bold text-sm">Social media links <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Link to the your social media that best promotes your service. Paste the full url containing https://</p>
			<textarea name="social_media_links" id="social_media_links" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.social_media_links" :disabled="plug != null && placeholder.social_media_links != null"> </textarea>
			<x-input-error :messages="$errors->get('social_media_links')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="usp" class="font-bold text-sm">Ace up your sleeve</label>
			<p class="text-sm text-greyish py-1">Unique selling point/Licences/Certification if available</p>
			<textarea name="usp" id="usp" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.usp" :disabled="plug != null && placeholder.usp != null"> </textarea>
			<x-input-error :messages="$errors->get('usp')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="travel" class="font-bold text-sm">Available for travel? <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Check the box to indicate your availability to travel.</p>
			<input type="checkbox" :checked="placeholder.travel" name="travel" id="travel" class="border p-2 border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 placeholder:text-gray-200" x-model="placeholder.travel" :value="placeholder.travel" :disabled="plug != null && placeholder.travel != null">
			<x-input-error :messages="$errors->get('travel')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="tags" class="font-bold text-sm">Service tags <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Add some tags to help in search like you'll do in twitter, separate using a comma.</p>
			<input type="text" name="tags" id="tags" required placeholder="blockparty, party, shayo, badman, vibesAndChill" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.tags" :disabled="plug != null && placeholder.tags != null">
			<x-input-error :messages="$errors->get('tags')" class="mt-2" />
		</div>

		<button class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 rounded-lg shadow-md md:shadow-sm disabled:bg-gray-400 disabled:text-purple-1000 disabled:shadow-none md:w-2/6 md:mt-8 hover:shadow-md shadow-sm hover:bg-red-800 hover:text-purple-200" type="submit" :disabled="plug != null">
			Create plug profile
		</button>
	</form>
</section>