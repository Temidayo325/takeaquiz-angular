@extends('layouts.user-dashboard')

@section('title', 'Become an event organizer on CruiseHq')

@section('content')
	<div class="text-purple-1000" x-data='{ summary: "",
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
            axios.post("/user/dashboard/promoter/request", {summary: this.summary})
            .then( ( response ) => {
                console.log(response)
                if(!response.error)
                {
                    this.toast("Your request has been received and will be attended to ASAP", "white", "green")
                    this.summary = ""
                }
            })
            .catch( (error) => {
                console.log(error)
                this.toast(error.response.data.message, "white", "red")
            })
        },
	}'>
		<section class="mt-2 grid gap-10 md:px-10">
            <div class="md:mt-10">
                <h2 class="font-bold font-body text-lg">Request for account upgrade to promoter</h2>
                <p>The promoter account provides with more controls and features, allowing you to upload your upcoming events, create tickets, and track attendance. Fill the form below to request for a promoter account </p>
            </div>
            <div>
                <form action="" method="post" x-show='notification == null'>
                    <label for="summary" class="font-bold block">Provide a brief introduction about yourself and the kind of event you'll like to host </label>
                    <textarea name="summary" id="summary" required="required" minlength="10" maxlength="2000" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-2/4 mt-2 invalid:border invalid:border-red-600 h-48 md:h-56 text-sm leading-7 " x-model="summary" ></textarea>

                    <button type="submit" @click.prevent="submitForm()" class="block px-10 py-3 bg-red-1000 text-gray-200 mt-3">Make request</button>
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

