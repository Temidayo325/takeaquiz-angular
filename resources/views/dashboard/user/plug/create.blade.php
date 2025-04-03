@extends('layouts.user-dashboard')

@section('title', 'Be a CruiseHq plug')

@section('content')
	<div class="text-purple-1000 py-4 max-w-7xl" x-data='{ error: { status: false, message: ""},
        disabled: false,
        plug: @json($user->plug),
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
                <h2 class="font-bold text-wrap font-display tracking-widest text-lg md:text-5xl mb-2">Become a CruiseHq plug</h2>
                <p class="font-body leading-7">The plug account provides access to list your services on the cruiseHq service directory which will help to improve awareness to our community about your services. Fill the form below to request for a promoter account </p>
            </div>

            <template x-if="plug.status == 'Suspended'">
                <p class="p-2 bg-red-300 text-purple-1000 leading-6">Your account has been suspended by the admin. Kindly reach out to the admin via email including the email address you used to register on CruiseHq to find out what the problem was.</p>
            </template>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl overflow-hidden">
                    <x-plugs.create :user="$user"></x-plugs.create>
                </div>
            </div>
            

            <div>
                <template x-if="notification != null && notification.status == 1">
                    <p class="p-2 bg-green-300 text-purple-1000 leading-6">Hurray!!! Your request has been granted. Your plug profile is now available on the plugs directory. Click on Plug spot in your side bar to search your plug info and share your profile</p>
                </template>
                <template x-if="notification != null && notification.status == 0">
                    <p class="p-2 bg-red-300 text-purple-1000 leading-6">Apologies for the late response, We currently  have a large volume of request to attend to, your request is still a priority to use and would be attended to ASAP </p>
                </template>
            </div>
		</section>
	</div>

@endsection

