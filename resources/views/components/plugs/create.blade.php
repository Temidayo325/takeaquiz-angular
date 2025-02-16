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
		<div class="mt-4">
			<label for="service" class="font-bold text-sm">Service Provided <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Select the category that best describes your service. Use commonly recognized names to improve your visibility. (Examples: DJ, Event Planner, Web Designer, Social Media Manager, Content Writer, Virtual Assistant, UI/UX Designer, etc.).</p>
			<input type="text" name="service" id="service" placeholder="Example. DJ" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" autofocus x-model="placeholder.service" :disabled="plug != null && placeholder.service != null" />			
			<x-input-error :messages="$errors->get('service')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="service_summary" class="font-bold text-sm">Service Summary <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">A brief description of what you offer, including key services and packages. (Example: "I provide custom website design and branding for businesses, including e-commerce stores, blogs, and landing pages.")</p>
			<textarea name="service_summary" id="service_summary" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.service_summary" :disabled="plug != null && placeholder.service_summary != null"></textarea>
			<x-input-error :messages="$errors->get('service_summary')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="tags" class="font-bold text-sm">Service Tags <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Add relevant keywords to help people find you. Separate tags with commas. (Examples: #DJ, #EventPlanner, #WebDesign, #DigitalMarketing, #RemoteWork, #LogoDesign, etc.)</p>
			<input type="text" name="tags" id="tags" required placeholder="blockparty, party, shayo, badman, vibesAndChill" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.tags" :disabled="plug != null && placeholder.tags != null">
			<x-input-error :messages="$errors->get('tags')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="usp" class="font-bold text-sm">Unique Selling Point / Certifications</label>
			<p class="text-sm text-greyish py-1">Highlight what makes your service stand out—special skills, licenses, awards, or unique expertise. (Examples: Certified Web Developer, Google Ads Certified, Over 10 years of experience in digital branding.)</p>
			<textarea name="usp" id="usp" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.usp" :disabled="plug != null && placeholder.usp != null"> </textarea>
			<x-input-error :messages="$errors->get('usp')" class="mt-2" />
		</div>

		<div class="">
			<label for="state" class="font-bold text-sm block">Location & Service Availability <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Select the state where your business is primarily located.</p>
			<select name="state" id="state" class="border border-purple-100 focus:outline-none focus:ring-0 focus:border-none focus:shadow-lg focus:border focus:border-gray-100 mt-2 w-full md:w-5/6 md:border-gray-300" x-model="placeholder.state" :disabled="plug != null && placeholder.state != null">
				<option value="" disabled>Select desired state</option>
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
			<x-input-error :messages="$errors->get('state')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="travel" class="font-bold text-sm">Available for Travel? (For in-person services only)<span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Check the box to indicate your availability to travel.</p>
			<input type="checkbox" :checked="placeholder.travel" name="travel" id="travel" class="border p-2 border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 placeholder:text-gray-200" x-model="placeholder.travel" :value="placeholder.travel" :disabled="plug != null && placeholder.travel != null">
			<x-input-error :messages="$errors->get('travel')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="address" class="font-bold text-sm">Contact & Social Media</label>
			<p class="text-sm text-greyish py-1">Website / Portfolio URL (For digital services) and links to your most relevant social media pages.</p>
			<input type="text" name="address" id="address" placeholder="https://luminaace.com.ng/" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.address" :disabled="plug != null && placeholder.address != null">
			<x-input-error :messages="$errors->get('address')" class="mt-2" />
		</div>

		<div class="mt-4">
			<label for="social_media_links" class="font-bold text-sm">Social media links <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Link to the your social media that best promotes your service. Paste the full url containing https://</p>
			<textarea name="social_media_links" id="social_media_links" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.social_media_links" :disabled="plug != null && placeholder.social_media_links != null"> </textarea>
			<x-input-error :messages="$errors->get('social_media_links')" class="mt-2" />
		</div>
		
		<div class="mt-4" >
			<label for="flier" class="font-bold text-sm block mb-1">Promotional Material (Flyer / Portfolio / Banner) <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
			<p class="text-sm text-greyish py-1">Upload an image (Max 2MB) to promote your service. If you provide virtual services, this could be a portfolio preview, a branded banner, or a flyer.</p>
			<input x-show="plug == null" accept="image/png, image/jpeg" type="file" name="flier" id="flier" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600" />
			<template x-if="plug != null ">
				<img :src="`{{ asset('/images') }}/${plug.flier}`" alt="flier of the plug" class="w-full h-56 mt-2">
			</template>
			<x-input-error :messages="$errors->get('flier')" class="mt-2" />
		</div>

		<button class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 rounded-lg shadow-md md:shadow-sm disabled:bg-gray-400 disabled:text-purple-1000 disabled:shadow-none md:w-2/6 md:mt-8 hover:shadow-md shadow-sm hover:bg-red-800 hover:text-purple-200" type="submit" :disabled="plug != null">
			Create plug profile
		</button>
	</form>
</section>