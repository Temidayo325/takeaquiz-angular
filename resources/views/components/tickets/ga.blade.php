<section x-data='{ event: {
				id: 13, user_id: 1, name: "Buju Phenomena gathering", state: "Lagos", starting_time: "04:11:24", event_date: "2024-11-25"}, 
				ticket: {price: 0, type_copy: "", total_seat: 0, available_seat: 0, type: ""},
				user: JSON.parse(localStorage.getItem("user")),
				ticket: JSON.parse(sessionStorage.getItem("ticket")),
				init()
				{
				
				}
			}'
			x-modelable="event"
			x-model="chosenEvent">
	<div>
		<div {{ $attributes->merge(['class' => 'bg-gray-500 pt-4 pb-10 rounded mx-auto text-gray-300 mt-2 text-center']) }} >
			<p class="text-md text-gray-200 py-2 block bg-transparent" x-text="user.nickname">Light</p>
			<h2 class="font-bold text-xl py-3 text-gray-200 block bg-gray-950" x-text="ticket.name">General admission</h2>
			<div class="px-4">
				<h2 class="text-3xl font-bold text-gray-200" x-text="chosenEvent.name">Name of the event</h2>
				<p class="mt-4 text-sm" x-text="chosenEvent.event_date">10th of August, 2024</p>
				<p x-text="new Date(chosenEvent.event_date).toDateString()">Sunday 10th of August, 2024 @ 4:00 PM</p>
				<p x-text="chosenEvent.location">31270 Rahul Roads Beckerview, KS 94569-2627</p>
				<p x-text="chosenEvent.state + ' '+ chosenEvent.state">Lagos state</p>
				<p class="pb-4">Event Organized by: <span x-text="chosenEvent.user.nickname"></span></p>
			</div>
			<div class="mt-10">
					<p>Price : 
						<span class="font-bold text-xl">&#8358; </span>
						<span x-text="new Intl.NumberFormat().format(ticket.price)"></span>
					</p>
				</div>
		</div>

		<div class="mt-10">
			<h2 class="font-bold text-left py-2 text-md">Perks of <span x-text="ticket.name"></span> ticket</h2>
			<p x-text="ticket.type_copy" class="text-left text-purple-1000 tracking-wider leading-8"></p>
		</div>
	</div>
</section>