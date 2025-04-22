@extends('layouts.tools')

@section('title', 'Checkout your ticket')

@section('content')
	<div class="text-black md:px-10 py-4" x-data='{ desiredTicket: @json($ticket),
		chosenEvent: null,
		init() {
            console.log(this.desiredTicket)
        	this.chosenEvent = ( this.desiredTicket == null ) ? null : this.desiredTicket.event
   		},
        checkout()
        {
            try {
                axios.post("/ticket/initiate-payment", {ticket_id: this.desiredTicket.id})
                .then(response => {
                    if( !response.data.error)
                    {
                        this.toast(response.data.message, "green")
                        window.location = "/user/dashboard"
                    }

                    if(response.data.error)
                    {
                        this.toast(response.data.message, "orange")
                    }
                })
                .catch(error => console.log(error))
            } catch (error) {
                this.toast(error.response.data.message, "red")
                console.error(error)
            }
        }
	}'>
        <template x-if="desiredTicket != null">
            <div>
                <div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
                    <div class="max-w-lg">
                        <h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">{{ $ticket->event->name ?? ''}}</h1>
                        <p class="text-md leading-7 my-4">{{$ticket->type_copy ?? ''}}</p>
                        <a href="/logo" class="px-6 py-3 font-bold md:font-normal bg-red-1000 text-gray-200">Continue with account creation</a>
                        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="underline py-2 px-4 font-bold mt-3 underline-offset-4" type="button">
                            Continue without creating account
                            </button>
                    </div>
                    <img src="{{ asset('/images/party.svg') }}" alt="People chilling" class="w-96 h-52">
                </div>

		        <h1 class="font-bold text-xl font-body py-4 mb-10 text-purple-1000">Complete your ticket purchase</h1>

                <div>
                    <x-tickets.early-bird class="w-64 md:w-96" :ticket="$ticket"></x-tickets.early-bird>
                </div>
            
                <div class="md:max-w-72 mt-10 md:hidden">
                    <a class="block text-white bg-purple-1000 hover:bg-red-1000 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center " href="/login">Continue with account creation</a>
                    <!-- Modal toggle  -->
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="underline py-2 px-4 font-bold mt-3 underline-offset-4" type="button">
                    Continue without creating account
                    </button>
                </div>
            </div>
        </template>

        <template x-if="desiredTicket == null">
            <div class="py-20 md:py-72 flex justify-center items-center">
                <p class="md:text-2xl font-bold font-body">There's no ticket with this description yet, kindly check the cruise calander to confirm</p>
            </div>
        </template>

     <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                FIll the form to get continue to ticket checkout
                            </h3>
                            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                        <form method="POST" action="#" class="mt-3 mb-7" 
                            x-data='{ user: {name: "", nickname: "", email: "", phone: "" },
                                spinner: false,
                                errorMessage: null,
                                createTicketButtonText: "Continue ",
                                toast(text, background){
                                    Toastify({
                                    text: text, 
                                    style: {
                                        background: background,
                                        color: "white"
                                    }
                                    }).showToast();
                                },
                                submitForm()
                                {
                                    $refs.createTicketButton.setAttribute("disabled", "")
                                    this.spinner = true
                                    this.createTicketButtonText = "Generating payment link .."
                                    this.toast("Generating payment link ...", "blue")

                                    axios.post("/ticket/initiate-payment", {user: this.user, ticket_id: desiredTicket.id})
                                    .then( (response) => {
                                        if(!response.data.error)
                                        {
                                            this.toast("Payment link generated, redirecting to payment", "green")
                                            setTimeout( () => {
                                                window.open(response.data.info.checkoutUrl, "_blank")
                                            }, 2000)
                                        }
                                        $refs.createTicketButton.removeAttribute("disabled")
                                        this.spinner = false
                                        this.createTicketButtonText = "Create event"
                                    })
                                    .catch( (error) => {
                                        this.spinner = false
                                        this.createTicketButtonText = "Create ticket"
                                        $refs.createTicketButton.removeAttribute("disabled")
                                        this.toast(error.response.data.message, "#DB162F")
                                        this.errorMessage = error.response?.data?.message || "An unexpected error occurred."
                                    })
                                }
                            }'>
                            @csrf
                            <div class="grid gap-4 md:grid-cols-2 md:gap-x-6 md:gap-y-5">
                                <!-- Name -->
                                <fieldset class="border border-gray-400 px-1 py-1">
                                    <legend class="px-2 ">Name</legend>

                                    <x-text-input id="name" class="block mt-1 w-full py-0" type="text" name="name" required autofocus autocomplete="name" placeholder="e.g. Ajanlekoko Tinubu" x-model="user.name"/>
                                </fieldset>

                                <!-- Email Address -->
                                <fieldset class="border border-gray-400 px-1 py-1">
                                    <legend class="px-2 ">Email</legend>

                                    <x-text-input id="email" class="block mt-1 w-full py-0" type="email" name="email" required autocomplete="email"  placeholder="e.g. tpainregime@gmail.com" x-model="user.email"/>
                                </fieldset>

                                <!-- Phone number -->
                                <fieldset class="border border-gray-400 px-1 py-1">
                                    <legend class="px-2 ">Phone number</legend>

                                    <x-text-input id="phone" class="block mt-1 w-full py-0" type="tel" name="phone" required autocomplete="phone" placeholder="07040473656" x-model="user.phone"/>
                                </fieldset>

                                <!-- Nickname -->
                                <fieldset class="border border-gray-400 px-1 py-1">
                                    <legend class="px-2 ">CruiseID</legend>

                                    <x-text-input id="nickname" class="block mt-1 w-full py-0" type="text" name="nickname" required placeholder="e.g. Tpain" x-model="user.nickname"/>
                                </fieldset>

                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-purple-1000 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>
                            </div>

                            <button class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 rounded-lg shadow-md md:shadow-sm disabled:bg-gray-400 disabled:text-purple-1000 disabled:shadow-none md:w-2/6 md:mx-auto" type="submit" @click.prevent="submitForm()" x-ref="createTicketButton">
                                <svg x-show="spinner" aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>
                                <span x-text="createTicketButtonText"></span>
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div> 

@endsection

