@extends('layouts.tools')

@section('title', 'Ticket purchase status')

@section('content')
	<div class="text-purple-1000 md:px-10 py-4" x-data='{ desiredTicket: @json($ticket),
		chosenEvent: null,
		init() {
        	this.chosenEvent = this.desiredTicket.event
   		},
	}'>
        <h2 class="font-bold text-2xl ">Confirm ticket purchase</h2>
		@if($error)
            <p class="my-4 p-3 bg-red-200 text-purple-1000 font-bold rounded">{{ $message }}</p>
        @endif

        @if(!$error)
            <p id="hs-run-on-click-run-confetti" class="my-4 p-3 bg-green-200 text-purple-1000 font-bold rounded">{{ $message }}</p>
        @endif

		<div class="mt-4">
    		<x-tickets.early-bird class="w-64 md:w-96" :ticket="$ticket"></x-tickets.early-bird>
		</div>
	</div>

    
    @if(!$error)
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            (function() {
                const runConfetti = document.querySelector('#hs-run-on-click-run-confetti');
                setTimeout(() => {
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: {
                            y: 0.6
                        }
                        });
                }, 1500);
                })();
        </script>
    @endif
@endsection