@extends('layouts.user-dashboard')

@section('title', 'Checkout your ticket')

@section('content')
	<div class="text-black px-0" x-data='{ user: @json($user),
		desiredTicket: @json($ticket),
		chosenEvent: null,
		init() {
        	sessionStorage.setItem("ticket", JSON.stringify(this.desiredTicket))
        	console.log(this.ticket)
        	this.chosenEvent = this.desiredTicket.event
   		}
	}'>
		<h1 class="font-bold text-lg py-4">Complete your ticket transaction</h1>
		<div>
			<template x-if="desiredTicket.type.length == 10">
    			<div>
    				{{-- <h2>This is early bird page</h2> --}}
    				<x-tickets.early-bird></x-tickets.early-bird>
    			</div>
    		</template>		
    		<template x-if="desiredTicket.type.length == 17">
    			<div>
    				<x-tickets.ga></x-tickets.ga>
    				{{-- <h2>This is General admission page</h2> --}}
    			</div>
    		</template>
    		<template x-if="desiredTicket.type.length == 3">
    			<div>
    				<x-tickets.vip>	</x-tickets.vip>
    				{{-- <h2>This is VIP page</h2> --}}
    			</div>
    		</template>	
		</div>
		<div class="flex justify-center items-center mt-8 mb-14">
			<button class="bg-gray-950 text-gray-200 px-10 py-2">Proceed to checkout</button>
		</div>
	</div>

@endsection

