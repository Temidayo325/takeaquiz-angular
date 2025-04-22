@props(['user'])
<section class="py-4 text-purple-1000 " x-data='{user: @json($user), 
			plug: @json($user->plug),
			placeholder: {logo: null, flier: null, service: null, service_summary: null, tags: null, address: null, state: null, social_media_links: null, travel: null, location_based: null, physical_address: null, contact_email: null, contact_portfolio: null, contact_whatsapp: null },
			init(){
				if(this.plug != null)
				{
					this.placeholder = this.plug
				}
			},
			async shareEvent()
			{
				let baseUrl = `${window.location.protocol}//${window.location.host}`;
				let shareData = {
					title: "My CruiseHq plug card",
					text: this.plug.service_summary,
					url: baseUrl + "/plug/" + this.plug.slug,
				}
				try {
					await navigator.share(shareData);
				} catch (err) {
				}
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
		}'>
	<h2 class="text-xl mb-4 font-bold text-center tracking-wider">Plug form</h2>
	<template x-if="plug === null">
		<form action="/plugs"
			method="POST" 
			enctype="multipart/form-data"
			class="grid gap-4 px-3 max-w-2/5">
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
		
			<!-- <form action="" @submit=""> -->
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
							<option value="abuja">Abuja</option>
							<option value="Abia">Abia</option>
							<option value="Adamawa">Adamawa</option>
							<option value="Akwa Ibom">Akwa Ibom</option>
							<option value="Anambra">Anambra</option>
							<option value="Bauchi">Bauchi</option>
							<option value="Bayelsa">Bayelsa</option>
							<option value="Borno">Borno</option>
							<option value="Cross river">Cross river</option>
							<option value="Delta">Delta</option>
							<option value="Ebonyi">Ebonyi</option>
							<option value="edo">Edo</option>
							<option value="ekiti">Ekiti</option>
							<option value="Enugu">Enugu</option>
							<option value="Gombe">Gombe</option>
							<option value="Imo">Imo</option>
							<option value="Jigawa">Jigawa</option>
							<option value="Kaduna">Kaduna</option>
							<option value="Kano">Kano</option>							
							<option value="kebbi">Kebbi</option>
							<option value="kogi">Kogi</option>
							<option value="kwara">Kwara</option>
							<option value="lagos">Lagos</option>
							<option value="Nasarawa">Nasarawa</option>
							<option value="Niger">Niger</option>
							<option value="Ogun">Ogun</option>
							<option value="ondo">Ondo</option>
							<option value="osun">Osun</option>
							<option value="Oyo">Oyo</option>
							<option value="Plateau">Plateau</option>
							<option value="rivers">Rivers</option>
							<option value="sokoto">Sokoto</option>
							<option value="Taraba">Taraba</option>
							<option value="Yobe">Yobe</option>
							<option value="Zamfara">Zamfara</option>
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

					<li class="mt-4">
						<label for="logo" class="font-bold text-sm block mb-1">Logo of the service <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
						<p class="text-sm text-greyish py-1">Upload the logo of your service outfit. Should be a simple square dimension less than 1MB.</p>
						<input x-show="plug == null" accept="image/png, image/jpeg" type="file" name="logo" id="logo" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600" />
						<template x-if="plug != null ">
							<img :src="`{{ asset('/images') }}/${plug.logo}`" alt="logo of the plug" class="w-full h-56 mt-2">
						</template>
						<x-input-error :messages="$errors->get('logo')" class="mt-2" />
					</li>
				</ul>
				<button class="px-5 py-3 bg-red-1000 border-none text-gray-200 mt-4 rounded-lg md:shadow-sm disabled:bg-gray-400 disabled:text-purple-1000 disabled:shadow-none md:px-10 md:mt-8 hover:shadow-md shadow-sm hover:bg-red-800 hover:text-purple-200" type="submit">
					Create plug profile
				</button>
			<!-- </form> -->
			</form>
		</template>
	
	<template x-if="plug != null">
		<div class=" overflow-x-hidden flex justify-center py-3">
			<div class="rounded-xl shadow-md md:w-96 md:mx-auto border-t border-gray-300">
				<div class="flex justify-end py-3 px-4">
					<svg @click="shareEvent()" class="text-purple-1000 w-10 font-bold cursor-pointer h-6 pr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" /></svg>
				</div>
				<div class="flex justify-center items-center pb-4 ">
					<img :src=`{{asset('images')}}/${plug.flier}` alt="" class="w-full h-24 md:h-44 rounded-tr-xl rounded-tl-xl mx-auto bg-white">
				</div>
				<div class="pb-3 border-b border-gray-400 text-center md:px-4">   
					<h3 class="font-bold text-lg tracking-wide text-center" x-text="user.nickname"></h3>
					<p x-text="user.name"></p>
					<p x-text="plug.state"></p>
					<p class="font-bold text-purple-1000 mt-3 text-left" x-text="plug.service"></p>
				</div>  
				<div class="grid mt-2 pb-4 md:px-4">
					<h3 class="font-bold mt-3 pb-2">Contact details</h3>
					<a :href=`tel:${user.phone}`> 
						<svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" /></svg>
						<span class="text-sm md:text-md" x-text="user.phone + ' , ' + plug.contact_whatsapp"></span>
					</a>
					<a :href="'mailto:'+ (plug.contact_email != null ) ? plug.contact_email : user.email"> 
						<svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" /></svg> <span x-text="( plug.contact_email != null) ? plug.contact_email : user.email"></span>
					</a>
					<a :href="plug.social_media_links" target="__blank"> <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
					<span x-text="plug.social_media_links"></span>
					</a>
				</div>
				<div class="md:px-4">
					<h3 class="font-bold mt-3 pb-0 text-sm">Service</h3>
					<p class="text-gray-500" x-text="plug.service"></p>

					<h3 class="font-bold text-sm mt-3">Service summary</h3>
					<p class="text-gray-500" x-text="plug.service_summary"></p>

					<h3 class="font-bold mt-3 text-sm">Plug's Unique Selling Point</h3>
					<p class="text-gray-500" x-text="plug.usp"></p>

				</div>
				<div class="grid mt-2 border-t border-gray-400 md:px-4">
					<h3 class="font-bold mt-3 text-sm">Service Availability</h3>
					<p class="text-gray-500" x-text="plug.location_based"></p>

					<h3 class="font-bold mt-3 text-sm">State</h3>
					<p class="text-gray-500" x-text="plug.state"></p>

					<h3 class="font-bold mt-3 text-sm">Contact Address (If location-based)</h3>
					<p class="text-gray-500" x-text="plug.physical_address"></p>

					<h3 class="font-bold mt-3 text-sm">Available for travel ?</h3>
					<p class="text-gray-500" x-text="( plug.travel == 1 ) ? 'Yes' : 'No'"></p>
				</div>
				<div class="grid mt-2 border-t border-gray-400 md:px-4 md:pb-5">
					<h3 class="font-bold mt-3 text-sm">Email</h3>
					<p class="text-gray-500 block" x-text="( plug.contact_email == null ) ? user.email : plug.contact_email"></p>

					<h3 class="font-bold mt-3 text-sm">Website / Portfolio</h3>
					<a :href=" ( plug.contact_portfolio == null) ? plug.social_media_links : plug.contact_portfolio" class="text-gray-500"></a>

					<h3 class="font-bold mt-3 text-sm">Phone / WhatsApp</h3>
					<a :href="'tel:' + ( plug.contact_whatsapp == null ) ? user.phone :  plug.contact_whatsapp" class="text-gray-500" x-text="( plug.contact_whatsapp == null ) ? user.phone :  plug.contact_whatsapp"></a>

					<h3 class="font-bold mt-3 text-sm">Social Media Links</h3>
					<a :href="plug.social_media_links" target="__blank" class="text-gray-500" x-text="plug.social_media_links"></a>
				</div>
			</div>
		</div>
	</template>
	
	<button 	
		x-show="plug != null"
		class="underline underline-offset-2 text-right mt-10 md:text-left cursor-pointer border-0" 
		data-drawer-target="drawer-right-example" 	
		data-drawer-show="drawer-right-example" 
		data-drawer-placement="right" 
		aria-controls="drawer-right-example" 
		id="right-drawer-button">
		Edit
	</button>
	
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
						<button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" x-ref="eventTicketTab">Edit plug info</button>
					</li>
				</ul>
			</div>
			<div id="default-styled-tab-content">
				<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tracking-wider overflow-x-scroll" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
					<form 	action="" 
							method="POST" 
							x-ref="form"
							@submit.prevent="submitForm()" 
							x-data='{error: "", hasError: false,
								spinner: false,
								errorMessage: null,
								submitForm()
								{
									$refs.createTicketButton.setAttribute("disabled", "")
									this.toast("Saving plug edit ...", "blue")
									let formdata = new FormData($refs.form)
									formdata.append("tags", this.placeholder.tags)
									formdata.append("id", this.placeholder.id)

									axios.post("/user/dashboard/plug/edit", formdata)
									.then( (response) => {
										if(response.data.errors != null)
										{
											this.toast(response.data.message, "orange")
											this.errorMessage = response.data.message
											this.hasError = true
										}
										
										if(!response.data.error)
										{
											this.toast("Edit made Succesfully", "green")
											this.hasError = false
											setTimeout(() => {
												location.href = "/user/dashboard/plug/request"
											}, 2000)
										}
										$refs.createTicketButton.removeAttribute("disabled")
									})
									.catch( (error) => {
										$refs.createTicketButton.removeAttribute("disabled")
										this.toast(error.response.data.message, "#DB162F")
										this.errorMessage = error.response.data.message
									})				
								}
					}'>
						<template x-show="hasError">
							<p x-text="error" class="text-left bg-red-300 p-3 rounded text-sm "></p>
						</template>
						<ul class="list-decimal grid gap-4 p-3">
							<li class="mt-4">
								<label for="service" class="font-bold text-sm">Service Provided <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
								<p class="text-sm text-greyish py-1">Select the category that best describes your service. Use commonly recognized names to improve your visibility. (Examples: DJ, Event Planner, Web Designer, Social Media Manager, Content Writer, Virtual Assistant, UI/UX Designer, etc.).</p>
								<input type="text" name="service" id="service" placeholder="Example. DJ" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" autofocus x-model="placeholder.service" />			
							</li>
							<li class="mt-4">
								<label for="service_summary" class="font-bold text-sm">Service Summary <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
								<p class="text-sm text-greyish py-1">A brief description of what you offer, including key services and packages. (Example: "I provide custom website design and branding for businesses, including e-commerce stores, blogs, and landing pages.")</p>
								<textarea name="service_summary" id="service_summary" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.service_summary"></textarea>
							</li>
							<li class="mt-4">
								<label for="tags" class="font-bold text-sm">Service Tags <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
								<p class="text-sm text-greyish py-1">Add relevant keywords to help people find you. Separate tags with commas. (Examples: DJ, EventPlanner, WebDesign, DigitalMarketing, RemoteWork, LogoDesign, etc.)</p>
								<input type="text" name="tags" id="tags" required placeholder="blockparty, party, shayo, badman, vibesAndChill" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.tags">
							</li>
							<li class="mt-4">
								<label for="usp" class="font-bold text-sm">Unique Selling Point / Certifications</label>
								<p class="text-sm text-greyish py-1">Highlight what makes your service stand out—special skills, licenses, awards, or unique expertise. (Examples: Certified Web Developer, Google Ads Certified, Over 10 years of experience in digital branding.)</p>
								<textarea name="usp" id="usp" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.usp"></textarea>
							</li>
							<li class="mt-4">
								<h4 class="mb-5 text-s, font-bold">Location & Service Availability </h4>
								
								<label for="location_based" class="font-bold text-sm block">Contact (If location-based) <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
								<div class="flex justify-start gap-4 text-sm py-2">
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

								<label for="state" class="font-bold text-sm block mt-5">State</label>
								<p class="text-sm text-greyish py-1">Select the state where your business is primarily located.</p>
								<select name="state" id="state" class="border border-purple-100 focus:outline-none focus:ring-0 focus:border-none focus:shadow-lg focus:border focus:border-gray-100 mt-2 w-full md:w-5/6 md:border-gray-300" x-model="placeholder.state">
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

								<label for="physical_address" class="font-bold text-sm block mt-5">Contact Address (If location-based)</label>
								<p class="text-sm text-greyish py-1">Check the box to indicate your availability to travel.</p>
								<textarea name="physical_address" id="physical_address" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.physical_address"></textarea>

								<h4 class="font-bold block mt-5 text-sm">Available for Travel? (For in-person services only)<sup class="text-red-700 ml-1 mb-10" title="This field must be filled">&#8727;</sup></h4>
								<p class="text-sm text-greyish py-1">Check the box to indicate your availability to travel.</p>
								<input type="checkbox" :checked="placeholder.travel" name="travel" id="travel" class="border p-2 border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 placeholder:text-gray-200" x-model="placeholder.travel">
								<label for="travel" class="text-sm">Yes</label>

							</li>
							<li class="mt-4">
								<h4 class="mb-5 text-s, font-bold">Contact & Social Media</h4>
								<p class="text-sm text-greyish py-1">(FIll at least one way for clients to reach you.)</p>

								<ul class="ml-4 list-disc grid gap-6">
									<li class="flex justify-center items-center gap-2">
										<label class="text-sm font-bold">Email</label>
										<input type="text" name="contact_email" id="contact_email" placeholder="youremail@gmail.com" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border-b invalid:border-red-600 placeholder:text-gray-200" x-model="placeholder.contact_email">
									</li>
									<li class="flex justify-start items-center gap-2">
										<label class="text-sm font-bold">Website / Portfolio (For digital services)</label>
										<input type="text" name="contact_portfolio" id="contact_portfolio" placeholder="youremail@gmail.com" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border-b invalid:border-red-600 placeholder:text-gray-200" value="{{ old('contact_portfolio') }}" x-model="placeholder.contact_portfolio">
									</li>
									<li class="flex justify-start items-center gap-2">
										<label class="text-sm font-bold">Phone / WhatsApp (Optional)</label>
										<input type="text" name="contact_whatsapp" id="contact_whatsapp" placeholder="youremail@gmail.com" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border-b invalid:border-red-600 placeholder:text-gray-200" value="{{ old('contact_whatsapp') }}" x-model="placeholder.contact_whatsapp">
									</li>
									<li class="">
										<label for="social_media_links" class="font-bold block text-sm">Social media links <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
										<p class="text-sm text-greyish py-1">Link to the your social media that best promotes your service. Paste the full url containing https:// (Example: Instagram, Twitter, LinkedIn, TikTok, Facebook, Behance, Dribbble, GitHub, etc.)</p>
										<textarea name="social_media_links" id="social_media_links" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="placeholder.social_media_links"></textarea>
									</li>
								</ul>
							</li>
							<li class="mt-4">
								<label for="flier" class="font-bold text-sm block mb-1">Promotional Material (Flyer / Portfolio / Banner) <span class="text-red-700 mb-10" title="This field must be filled">&#8727;</span></label>
								<p class="text-sm text-greyish py-1">Upload an image (Max 2MB) to promote your service. If you provide virtual services, this could be a portfolio preview, a branded banner, or a flyer.</p>
								<input accept="image/png, image/jpeg" type="file" name="flier" id="flier" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600" />
								<template x-if="plug != null ">
									<img :src="`{{ asset('/images') }}/${plug.flier}`" alt="flier of the plug" class="w-full h-56 mt-2">
								</template>
							</li>
						</ul>

						<button class="px-5 py-3 bg-red-900 border-none text-gray-200 mt-4 rounded-lg md:shadow-sm disabled:bg-gray-400 disabled:text-purple-900 disabled:shadow-none md:px-10 md:mt-8 hover:shadow-md shadow-sm hover:bg-red-800 hover:text-purple-200" 
							x-ref="createTicketButton" 
							type="submit">
							Submit edit
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>