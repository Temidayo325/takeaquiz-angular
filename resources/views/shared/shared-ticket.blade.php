@extends('layouts.tools')

@section("title", "View shared Ticket")

@section('content')
    <section class="text-purple-1000" x-data='{
        "ticket": @json($ticket),
        "user": JSON.parse(localStorage.getItem("user")),
        init()
        {
            console.log(this.ticket)
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
        <h1 class="font-bold font-display tracking-widest text-md">Event details</h1>
        <template x-if="ticket.hasOwnProperty('event_id')">
            <div>
            <div class="grid gap-4 md:flex md:gap-10 md:justify-start mt-3 tracking-wider">
                <div>
                    <img :src="`{{ asset('/images') }}/${ticket.event.flier}`" alt="Event flier" :title="ticket.event.name + ' Event flier'" class="md:w-96 md:h-auto">
                    <h3 class="font-bold font-body tracking-wider text-center text-xl mt-4" x-text="ticket.event.name"></h3>
                </div>
                <div class="grid gap-4 mt-2 md:gap-2">
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
            <h1 class="mt-8 font-bold font-display tracking-widest text-md">Ticket policy</h1>
            <div class="mt-3 grid grid-cols-4">
                <div class="gap-8">
                    <template x-if="ticket.type == 'Early bird'">
                        <div class="">
                            <div class="bg-white px-4 py-10 pb-5 rounded min-w-48 md:w-64 text-purple-1000 font-body mt-2 text-center border border-gray-200 shadow-md hover:shadow-lg ">
                                <div>
                                    <div class="border-b border-black">
                                        <h2 class="text-3xl font-display" x-text="ticket.event.name"></h2>
                                        <p class="text-sm py-3" x-text="ticket.event.starting_time + ' , ' + ticket.event.event_date"></p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6 text-left mt-5">
                                        <div class="pb-3 border-b border-gray-300">
                                            <p class="text-greyish text-sm">Ticket owner</p>
                                            <p class="text-lg text-purple-1000" x-text="user != null ? user.nickname : 'Your name goes here'">CruiseHq</p>
                                        </div>
                                        <div class="pb-3 border-b border-gray-300">
                                            <p class="text-greyish text-sm">Organizer</p>
                                            <p class="text-lg text-purple-1000" x-text="ticket.event.user.nickname">Your name</p>
                                        </div>
                                        <div class="pb-3 border-b border-gray-300">
                                            <p class="text-greyish text-sm">Date</p>
                                            <p class="text-purple-1000" x-text="new Date(ticket.event.event_date).toDateString()"></p>
                                        </div>
                                        <div class="pb-3 border-b border-gray-300">
                                            <p class="text-greyish text-sm">Time</p>
                                            <p class="text-purple-1000" x-text="ticket.event.starting_time">4:00 PM</p>
                                        </div>
                                        <div class="pb-3 border-b border-gray-300">
                                            <p class="text-greyish text-sm">Location</p>
                                            <p class="text-purple-1000" x-text="ticket.event.location"></p>
                                        </div>
                                        <div class="pb-3 border-b border-gray-300">
                                            <p class="text-greyish text-sm">State</p>
                                            <p class="text-purple-1000" x-text="ticket.event.state"></p>
                                        </div>
                                    </div>
                                    <div class="mt-10">
                                        <p>	
                                            <span class="font-bold text-xl text-purple-1000">&#8358; </span>
                                            <span class="font-bold text-xl text-purple-1000" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 md:mt-10 text-purple-1000">
                                <h2 class="font-bold text-left py-2 text-md font-body md:text-lg">Perks of the <span x-text="ticket.name"></span> ticket</h2>
                                <p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
                            </div>
                            <div class="flex justify-center items-center mb-10 mt-4">
                                <button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-red-1000 text-gray-100">Get ticket</button>
                            </div>
                        </div>
                    </template>		
                    <template x-if="ticket.type == 'General admission'">
                        <div>
                            <div class="bg-greyish pt-4 pb-10 rounded min-w-48 md:w-64 mx-auto text-gray-300 mt-2 text-center ">
                                <p class="text-md py-2 block bg-transparent" x-text="user != null ? user.nickname : 'My CruiseID'">Light</p>
                                <h2 class="text-md py-3 block text-greyish bg-purple-1000" x-text="ticket.event.name">General admission</h2>
                                <div class="px-4">
                                    <h2 class="text-4xl font-display text-purple-1000 my-2" x-text="ticket.event.name">Name of the event</h2>
                                    <p class="mt-4 text-sm" x-text="ticket.event.event_date">10th of August, 2024</p>
                                    <p x-text="new Date(ticket.event.event_date).toDateString()" class="my-3">Sunday 10th of August, 2024 @ 4:00 PM</p>
                                    <p x-text="ticket.event.location" class="my-2">31270 Rahul Roads Beckerview, KS 94569-2627</p>
                                    <p x-text="ticket.event.state">Lagos state</p>
                                    <p class="pb-4">Event Organized by: <span x-text="ticket.event.user.nickname"></span></p>
                                </div>
                                <div class="mt-10">
                                    <p>	
                                        <span class="font-bold text-xl text-purple-1000">&#8358; </span>
                                        <span class="font-bold text-xl text-purple-1000" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 md:mt-10 text-purple-1000">
                                <h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
                                <p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
                            </div>
                            <div class="flex justify-center items-center mb-10 mt-4">
                                <button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-red-1000 text-gray-100">Get ticket</button>
                            </div>
                        </div>
                    </template>
                    <template x-if="ticket.type == 'vip'">
                        <div class="">
                            <div class="px-4 bg-purple-1000 py-6 pb-10 rounded min-w-48 md:w-64 mx-auto text-gray-300 mt-2 text-center shadow-md border border-gray-200 hover:shadow-3xl hover:border-gray-100 relative ">
                                <div class="grid gap-4">
                                    <div>
                                        <p class="text-sm " x-text="user != null ? user.nickname : 'Your names goes here'">Light's</p>
                                        <h2 class="font-bold text-4xl py-2 text-red-1000">VIP</h2>
                                        <p class="text-sm">ticket</p>
                                    </div>
                                    <div>
                                        <p x-text="ticket.event.user.nickname" class="">Name of the Organizer</p>
                                        <p class="">presents</p>
                                        <h2 class="text-4xl font-display text-red-1000 py-3" x-text="ticket.event.name">Name of the event</h2>
                                    </div>
                                    <div class="">
                                        <p class="mt-4 text-sm" x-text="ticket.event.event_date">10th of August, 2024</p>
                                        <p>
                                            <span x-text="new Date(ticket.event.event_date).toDateString()"></span> @ 
                                            <span x-text="ticket.event.starting_time"></span>
                                        </p>
                                        <p class="mt-4 text-sm" x-text="ticket.event.location">Location: 31270 Rahul Roads Beckerview, KS 94569-2627</p>
                                        <p x-text="ticket.event.state">Lagos state</p>
                                    </div>
                                </div>
                                <div class="mt-10">
                                    <p>	
                                        <span class="font-bold text-xl text-red-1000 font-body">&#8358; </span>
                                        <span class="font-bold text-xl text-red-1000 font-body" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 md:mt-10 text-purple-1000">
                                <h2 class="font-bold text-left py-2 text-md font-body md:text-lg">USP of <span x-text="ticket.type"></span></h2>
                                <p x-text="ticket.type_copy" class="text-left tracking-wider leading-8 text-sm md:text-md"></p>
                            </div>
                            <div class="flex justify-center items-center mb-10 mt-4">
                                <button @click="initiateTicketPurchase(ticket.id)" class="py-3 px-8 bg-red-1000 text-gray-100">Get ticket</button>
                            </div>
                        </div>
                    </template>	
                </div>
            </div>
            </div>
        </template>
        <template x-if="ticket.length == 0">
            <h2 class="text-center text-lg tracking-wide leading-10 font-body my-32">There's no ticket with this description yet, kindly confirm that you have not modified any part of the url</h2>
        </template>
        
    </section>
@endsection