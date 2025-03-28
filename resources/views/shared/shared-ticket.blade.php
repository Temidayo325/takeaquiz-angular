@extends('layouts.tools')

@section("title", "View shared Ticket")

@section('content')
    <section class="text-purple-1000" x-data='{
        "ticket": @json($ticket),
        chosenEvent: null,
        "user": JSON.parse(localStorage.getItem("user")),
        init()
        {
            this.chosenEvent = this.ticket.event
        },
        initiateTicketPurchase(ticket_id)
   		{
   			try {
                axios.post("/user/dashboard/tickets/checkout", {ticket_id: ticket_id})
                .then(response => {
                	if( !response.data.error )
                	{
                		window.location.href = "/user/dashboard/ticket/checkout"
                	}
            	})
                .catch(error => console.log(error))
            } catch (error) {
                console.error(error)
            }
   		},
    }'>
        <h1 class="font-bold font-display tracking-widest text-md md:text-2xl mt-4">Event details</h1>
        <template x-if="ticket.hasOwnProperty('event_id')">
            <div>
            <div class="grid gap-4 mt-3 tracking-wider">
                <div class="py-4">
                    <img :src="`{{ asset('/images') }}/${ticket.event.flier}`" alt="Event flier" :title="ticket.event.name + ' Event flier'" class="md:w-2/4 md:mx-auto md:h-auto">
                    <h3 class="font-bold font-body tracking-wider text-center text-xl mt-4" x-text="ticket.event.name"></h3>
                </div>
                <div class="grid md:grid-cols-2 gap-4 mt-2 md:w-2/4 md:gap-10 md:gap-y-6">
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Event date</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.event_date"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Event time</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.starting_time"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Event duration</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.duration"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">State</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.state"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Address</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.location"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Event offering</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.promotional_copy"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Preferable audience</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.audience"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Event hotline</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.contact_information"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm font-body text-gray-500">Dress code</h4>
                        <p class="font-body text-md text-purple-1000" x-text="ticket.event.dress_code"></p>
                    </div>
                </div>
            </div>
            <h1 class="mt-8 md:mt-20 font-bold font-display tracking-widest text-md md:text-2xl">Ticket policy</h1>
            <div class="mt-3 md:mt-10 grid justify-start gap-6">
                <div>
                    <x-tickets.early-bird class="w-64 md:w-96" :ticket="$ticket"></x-tickets.early-bird>
                </div>
                <div class="flex justify-center py-4 mb-20">
                    <a href="/ticket/checkout/{{$ticket->slug}}" class="md:max-w-64 bg-red-1000 text-gray-200 py-3 px-6 rounded block text-center hover:bg-red-700 ">Purchase ticket</a>
                </div>
            </div>
            </div>
        </template>
        <template x-if="ticket.length == 0">
            <h2 class="text-center text-lg tracking-wide leading-10 font-body my-32">There's no ticket with this description yet, kindly confirm that you have not modified any part of the url</h2>
        </template>
        
    </section>
@endsection