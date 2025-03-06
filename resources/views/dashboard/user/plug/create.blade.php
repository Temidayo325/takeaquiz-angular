@extends('layouts.user-dashboard')

@section('title', 'Be a CruiseHq plug')

@section('content')
	<div class="text-purple-1000" x-data='{ plug: { service: null, service_summary: null },
        error: { status: false, message: ""},
        disabled: false,
        notification: @json($notification),
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
        submitForm(){
            this.toast("Sending request", "white", "blue")
            axios.post("/user/dashboard/plug/request", {...this.plug})
            .then( ( response ) => {
                if(!response.error)
                {
                    this.toast("Your request has been received and will be attended to ASAP", "white", "green")
                    this.disabled = true
                    this.error.status = false
                }
            })
            .catch( (error) => {
                this.error.status = true
                this.error.message = error.response.data.message
                this.toast(error.response.data.message, "white", "red")
            })
        },
	}'>
		<section class="mt-2 grid gap-10 md:px-10">
            <div class="md:mt-10">
                <h2 class="font-bold font-display tracking-widest text-lg md:text-2xl mb-2">Request for account upgrade to plug</h2>
                <p class="font-body leading-8">The plug account provides access to list your services on the cruiseHq service directory which will help to improve awareness to our community about your services. Fill the form below to request for a promoter account </p>
            </div>
            <div>
                <p x-show="error.status" class="bg-red-300 text-purple-1000 py-3 rounded" x-text="error.message"></p>
                <form action="" method="post" x-show='notification == null' class="grid gap-4 md:gap-10">
                    <div>
                    <label for="service" class="font-bold text-sm">Service Provided <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
                    <p class="text-sm text-greyish py-1">Select the category that best describes your service. Use commonly recognized names to improve your visibility. (Examples: DJ, Event Planner, Web Designer, Social Media Manager, Content Writer, Virtual Assistant, UI/UX Designer, etc.).</p>
                    <input type="text" name="service" id="service" placeholder="Example. DJ" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 placeholder:text-gray-200" autofocus x-model="plug.service" :disabled="disabled"/>			
                    </div>

                    <div>
                    <label for="service_summary" class="font-bold text-sm">Service Summary <sup class="text-red-700 mb-10" title="This field must be filled">&#8727;</sup></label>
                    <p class="text-sm text-greyish py-1">A brief description of what you offer, including key services and packages. (Example: "I provide custom website design and branding for businesses, including e-commerce stores, blogs, and landing pages.")</p>
                    <textarea name="service_summary" id="service_summary" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full invalid:border invalid:border-red-600 h-48 text-sm leading-7 " x-model="plug.service_summary" :disabled="disabled"></textarea>
                    </div>

                    <button type="submit" @click.prevent="submitForm()" class="block px-10 py-3 bg-red-1000 text-gray-200 mt-3 hover:bg-red-900 hover:text-gray-100">Make request</button>
                </form>
            </div>
            <div>
                <template x-if="notification != null && notification.status == 1">
                    <p class="p-2 bg-green-300 text-purple-1000 leading-6">Hurray!!! Your request has been granted. Click on the Event management link to see more options on event creation. </p>
                </template>
                <template x-if="notification != null && notification.status == 0">
                    <p class="p-2 bg-red-300 text-purple-1000 leading-6">Apologies for the late response, We currently  have a large volume of request to attend to, your request is still a priority to use and would be attended to ASAP </p>
                </template>
            </div>
		</section>
	</div>

@endsection

