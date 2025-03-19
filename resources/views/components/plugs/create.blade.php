@props(['user'])
<section class="py-4 text-purple-1000">
	<h2 class="text-xl mb-4 font-bold text-center tracking-wider">Plug form</h2>
	<form action="/plugs"
		x-data='{plug: @json($user), 
			placeholder: {flier: null, service: null, service_summary: null, tags: null, address: null, state: null, social_media_links: null, travel: null, location_based: null, physical_address: null, contact_email: null, contact_portfolio: null, contact_whatsapp: null },
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
		<div>
			<x-input-error :messages="$errors->get('error')" class="mt-2" />
		</div>
		@if(session('success'))
			<div id="flash-message" class="py-3 px-2 bg-green-300 text-purple-1000 text-left text-sm">
				{{ session('success') }}
			</div>

			<script>
				setTimeout(() => {
					let flashMessage = document.getElementById('flash-message');
					if (flashMessage) {
						flashMessage.style.transition = "opacity 0.5s ease";
						flashMessage.style.opacity = "0";
						setTimeout(() => flashMessage.remove(), 500); // Remove after fade out
					}
				}, 10000); // 10 seconds
			</script>
		@endif
		<ul class="list-decimal grid gap-4">
			<li class="mt-4">
				<label for="service" class="font-bold text-sm">Service Provided <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
				<p class="text-sm text-greyish py-1">Select the category that best describes your service. Use commonly recognized names to improve your visibility. (Examples: DJ, Event Planner, Web Designer, Social Media Manager, Content Writer, Virtual Assistant, UI/UX Designer, etc.).</p>
				<input type="text" name="service" id="service" placeholder="Example. DJ" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" autofocus x-model="placeholder.service" value="{{ old('service') }}" :disabled="plug != null && placeholder.service != null" />			
				<x-input-error :messages="$errors->get('service')" class="mt-2" />
			</li>
			<li class="mt-4">
				<label for="service_summary" class="font-bold text-sm">Service Summary <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
				<p class="text-sm text-greyish py-1">A brief description of what you offer, including key services and packages. (Example: "I provide custom website design and branding for businesses, including e-commerce stores, blogs, and landing pages.")</p>
				<textarea name="service_summary" id="service_summary" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.service_summary" :disabled="plug != null && placeholder.service_summary != null"> {{ old('service_summary') }}</textarea>
				<x-input-error :messages="$errors->get('service_summary')" class="mt-2" />
			</li>
			<li class="mt-4">
				<label for="tags" class="font-bold text-sm">Service Tags <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
				<p class="text-sm text-greyish py-1">Add relevant keywords to help people find you. Separate tags with commas. (Examples: DJ, EventPlanner, WebDesign, DigitalMarketing, RemoteWork, LogoDesign, etc.)</p>
				<input type="text" name="tags" id="tags" required placeholder="blockparty, party, shayo, badman, vibesAndChill" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.tags" value="{{ old('tags') }}" :disabled="plug != null && placeholder.tags != null">
				<x-input-error :messages="$errors->get('tags')" class="mt-2" />
			</li>
			<li class="mt-4">
				<label for="usp" class="font-bold text-sm">Unique Selling Point / Certifications</label>
				<p class="text-sm text-greyish py-1">Highlight what makes your service stand out—special skills, licenses, awards, or unique expertise. (Examples: Certified Web Developer, Google Ads Certified, Over 10 years of experience in digital branding.)</p>
				<textarea name="usp" id="usp" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.usp" :disabled="plug != null && placeholder.usp != null"> {{ old('usp') }} </textarea>
				<x-input-error :messages="$errors->get('usp')" class="mt-2" />
			</li>
			<li class="mt-4">
				<h4 class="mb-5 text-s, font-bold">Location & Service Availability </h4>
				
				<label for="location_based" class="font-bold text-sm block">Contact (If location-based) <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
				<div class="flex justify-start gap-4 text-sm py-2" readonly="plug == null || placeholder.location_based != null">
					<div>
						<input id="remote" name="location_based" type="radio" value="Remote" x-model="placeholder.location_based">
						<label for="remote">Remote</label>
					</div>
					<div>
						<input id="in-person" name="location_based" type="radio" value="In-person" x-model="placeholder.location_based">
						<label for="in-person">In-person</label>
					</div>
					<div>
						<input id="hybrid" name="location_based" type="radio" value="Hybrid" x-model="placeholder.location_based">
						<label for="hybrid">Hybrid</label>
					</div>
				</div>
				<template x-if="plug != null && placeholder.location_based != null">
					<p x-text="placeholder.location_based"></p>
				</template>
				<x-input-error :messages="$errors->get('location_based')" class="mt-2" />


				<label for="state" class="font-bold text-sm block mt-5">State</label>
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


				<label for="physical_address" class="font-bold text-sm block mt-5">Contact Address (If location-based)</label>
				<p class="text-sm text-greyish py-1">Check the box to indicate your availability to travel.</p>
				<textarea name="physical_address" id="physical_address" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.physical_address" :disabled="plug != null && placeholder.physical_address != null"> {{ old('physical_address') }}  </textarea>
				<x-input-error :messages="$errors->get('physical_address')" class="mt-2" />


				<h4 class="font-bold block mt-5 text-sm">Available for Travel? (For in-person services only)<sup class="text-red-700 ml-1 mb-10" title="This field must be filled">&#8727;</sup></h4>
				<p class="text-sm text-greyish py-1">Check the box to indicate your availability to travel.</p>
				<input type="checkbox" :checked="placeholder.travel" name="travel" id="travel" class="border p-2 border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 placeholder:text-gray-200" x-model="placeholder.travel" :value="placeholder.travel" :disabled="plug != null && placeholder.travel != null">
				<label for="travel" class="text-sm">Yes</label>

				<x-input-error :messages="$errors->get('travel')" class="mt-2" />
			</li>
			<li class="mt-4">
				<h4 class="mb-5 text-s, font-bold">Contact & Social Media</h4>
				<p class="text-sm text-greyish py-1">(FIll at least one way for clients to reach you.)</p>

				<ul class="ml-4 list-disc grid gap-6">
					<li class="flex justify-center items-center gap-2">
						<label class="text-sm font-bold">Email</label>
						<input type="text" name="contact_email" id="contact_email" placeholder="youremail@gmail.com" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border-b invalid:border-red-600 placeholder:text-gray-200" value="{{ old('contact_email') }}" x-model="placeholder.contact_email" :disabled="plug != null && placeholder.contact_email != null">
						<x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
					</li>
					<li class="flex justify-start items-center gap-2">
						<label class="text-sm font-bold">Website / Portfolio (For digital services)</label>
						<input type="text" name="contact_portfolio" id="contact_portfolio" placeholder="youremail@gmail.com" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border-b invalid:border-red-600 placeholder:text-gray-200" value="{{ old('contact_portfolio') }}" x-model="placeholder.contact_portfolio" :disabled="plug != null && placeholder.contact_portfolio != null">
						<x-input-error :messages="$errors->get('contact_portfolio')" class="mt-2" />
					</li>
					<li class="flex justify-start items-center gap-2">
						<label class="text-sm font-bold">Phone / WhatsApp (Optional)</label>
						<input type="text" name="contact_whatsapp" id="contact_whatsapp" placeholder="youremail@gmail.com" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border-b invalid:border-red-600 placeholder:text-gray-200" value="{{ old('contact_whatsapp') }}" x-model="placeholder.contact_whatsapp" :disabled="plug != null && placeholder.contact_whatsapp != null">
						<x-input-error :messages="$errors->get('contact_whatsapp')" class="mt-2" />
					</li>
					<li class="">
						<label for="social_media_links" class="font-bold block text-sm">Social media links <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Link to the your social media that best promotes your service. Paste the full url containing https:// (Example: Instagram, Twitter, LinkedIn, TikTok, Facebook, Behance, Dribbble, GitHub, etc.)</p>
						<textarea name="social_media_links" id="social_media_links" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.social_media_links" :disabled="plug != null && placeholder.social_media_links != null"> {{ old('social_media_links') }} </textarea>
						<x-input-error :messages="$errors->get('social_media_links')" class="mt-2" />
					</li>
				</ul>
			</li>
			<li class="mt-4">
				<label for="flier" class="font-bold text-sm block mb-1">Promotional Material (Flyer / Portfolio / Banner) <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
				<p class="text-sm text-greyish py-1">Upload an image (Max 2MB) to promote your service. If you provide virtual services, this could be a portfolio preview, a branded banner, or a flyer.</p>
				<input x-show="plug == null" accept="image/png, image/jpeg" type="file" name="flier" id="flier" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600" />
				<template x-if="plug != null ">
					<img :src="`{{ asset('/images') }}/${plug.flier}`" alt="flier of the plug" class="w-full h-56 mt-2">
				</template>
				<x-input-error :messages="$errors->get('flier')" class="mt-2" />
			</li>
		</ul>

		<button class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 rounded-lg md:shadow-sm disabled:bg-gray-400 disabled:text-purple-1000 disabled:shadow-none md:w-2/6 md:mt-8 hover:shadow-md shadow-sm hover:bg-red-800 hover:text-purple-200" type="submit" :disabled="plug != null">
			Create plug profile
		</button>
	</form>
</section>