@extends('layouts.user-dashboard')

@section('title', 'Checkout your ticket')

@section('content')
	<div class="text-black px-4 md:px-10 py-6" x-data='{ user: @json($user),
		desiredTicket: @json($ticket),
		chosenEvent: null,
		init() {
        	sessionStorage.setItem("ticket", JSON.stringify(this.desiredTicket))
        	this.chosenEvent = this.desiredTicket.event
   		},
        toast(text, background){
            Toastify({
              text: text, 
              style: {
                background: background,
                color: "white"
              }
            }).showToast();
        },
        checkout()
        {
            try {
                axios.post("/user/dashboard/ticket/initiate-payment", {ticket_id: this.desiredTicket.id})
                .then(response => {
                    if( !response.data.error && this.desiredTicket.access_type == "Free")
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
		<h1 class="font-bold text-lg py-4">Complete your ticket transaction</h1>
		<div>
			<template x-if="desiredTicket.type.length == 10">
    			<div>
    				{{-- <h2>This is early bird page</h2> --}}
    				<x-tickets.early-bird class="w-64 md:w-96 mx-auto" :ticket="$ticket"></x-tickets.early-bird>
    			</div>
    		</template>		
    		<template x-if="desiredTicket.type.length == 17">
    			<div>
    				<x-tickets.ga class="w-64 md:w-96 mx-auto" :ticket="$ticket"></x-tickets.ga>
    				{{-- <h2>This is General admission page</h2> --}}
    			</div>
    		</template>
    		<template x-if="desiredTicket.type.length == 3">
    			<div>
    				<x-tickets.vip class="w-64 md:w-96 mx-auto" :ticket="$ticket"></x-tickets.vip>
    				{{-- <h2>This is VIP page</h2> --}}
    			</div>
    		</template>	
		</div>
        <p class="text-red-1000 font-bold py-3 text-center"><span class="text-lg">&#8358; </span><span x-text="desiredTicket.price"></span> would be deducted from your wallet</p>
		@auth
        <div class="flex justify-center items-center mt-4 mb-14">
			<button class="bg-gray-950 text-gray-200 px-6 py-3" @click="checkout()">
                Continue to checkout
                <svg class="animate-bounce w-10 h-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" /></svg>
            </button>
		</div>
        @endauth
        @guest
            <a class="text-center underline text-purple-1000" href="/login">Create an account to continue to ticket</a>
        @endguest
	</div>

@endsection

