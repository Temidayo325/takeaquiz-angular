@props(['ticket'])
<style>
	#ticket-container{
			background-image: url('https://cruisehq.fun/cruise-back-yellow.png'); 
			background-repeat: no-repeat; 
			background-size: 100% 100% ; 
			background-origin: center; 
			position: relative;
			padding: 65px 40px;
			text-align: left;
			margin: 0 auto;
			min-width: 270px;
			max-width: 300px;
		}
</style>
<section class="grid gap-6 text-purple-1000 justify-start md:justify-start md:grid-cols-2" 
			x-data='{ event: {
				id: 13, user_id: 1, name: "Buju Phenomena gathering", state: "Lagos", starting_time: "04:11:24", event_date: "2024-11-25"}, 
				ticket: @json($ticket),
				init()
				{
					
				}
			}'
			x-modelable="event"
			x-model="chosenEvent"
>
	<div id="ticket-container" class='rounded-3xl mt-2 text-center font-body' >
		<div class="">
			<div class="border-b border-black text-center">
				<h2 class="text-3xl font-bold" x-text="chosenEvent.name"></h2>
				<p class="text-sm font-bold py-2" x-text="chosenEvent.starting_time + ' ,' + chosenEvent.event_date"></p>
			</div>
			<div class="grid grid-cols-2 gap-6 text-left mt-5">
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Ticket owner</p>
					<p class="font-bold text-purple-1000">Your name</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Organizer</p>
					<p class="font-bold text-purple-1000" x-text="chosenEvent.user.nickname">CruiseHq</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Date</p>
					<p class="font-bold text-purple-1000" x-text="new Date(chosenEvent.event_date).toDateString()"></p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Time</p>
					<p class="font-bold text-purple-1000" x-text="chosenEvent.starting_time">4:00 PM</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Location</p>
					<p class="font-bold text-purple-1000" x-text="chosenEvent.location"></p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-greyish text-sm">State</p>
					<p class="font-bold" x-text="chosenEvent.state"></p>
				</div>
			</div>
			<div class="mt-10 text-purple-1000">
				<p>
					<span x-text="ticket.name + ' ticket price'"></span>
					<span class="font-bold text-2xl">&#8358; </span>
					<span class="font-bold text-2xl" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
				</p>
			</div>
		</div>
	</div>
	<div class="mt-6">
		<h2 class="font-bold text-left py-2 text-md">Perks of <span x-text="ticket.name"></span> ticket</h2>
		<p x-text="ticket.type_copy" class="text-left text-gray-950 text-sm tracking-wider leading-8"></p>
	</div>
</section>