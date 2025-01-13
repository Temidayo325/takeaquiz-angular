<section 	class="grid gap-6 text-purple-1000" 
			x-data='{ event: {
				id: 13, user_id: 1, name: "Buju Phenomena gathering", state: "Lagos", starting_time: "04:11:24", event_date: "2024-11-25"}, 
				ticket: {price: 0, type_copy: "", total_seat: 0, available_seat: 0, type: ""},
				user: JSON.parse(localStorage.getItem("user")),
				ticket: JSON.parse(sessionStorage.getItem("ticket"))
			}'
			x-modelable="event"
			x-model="chosenEvent">
	<div class="">
		<div class="px-4 bg-purple-1000 py-6 pb-10 rounded w-64 md:w-64 mx-auto text-gray-200 mt-2 text-center shadow-md border border-gray-200 duration-700 hover:shadow-3xl hover:border-gray-100 relative ">
			<div class="grid gap-4">
				<div>
					<p class="text-sm text-gray-400" x-text="user.nickname">Light's</p>
					<h2 class="font-bold text-4xl py-2 text-amber-800">VIP</h2>
					<p class="text-sm text-gray-400">ticket</p>
				</div>
				<div>
					<p x-text="chosenEvent.user.nickname" class="text-gray-200">Name of the Organizer</p>
					<p class="text-gray-500">presents</p>
					<h2 class="text-4xl font-bold text-amber-600 py-3" x-text="chosenEvent.name">Name of the event</h2>
				</div>
				<div class="">
					<p class="mt-4 text-sm" x-text="chosenEvent.event_date">10th of August, 2024</p>
					<p>
						<span x-text="new Date(chosenEvent.event_date).toDateString()"></span> @ 
						<span x-text="chosenEvent.starting_time"></span>
					</p>
					<p class="mt-4 text-sm" x-text="chosenEvent.location">Location: 31270 Rahul Roads Beckerview, KS 94569-2627</p>
					<p x-text="chosenEvent.state">Lagos state</p>
				</div>
			</div>
			<div class="mt-10">
				<p>Price : 
					<span class="font-bold text-xl">&#8358; </span>
					<span x-text="new Intl.NumberFormat().format(ticket.price)"></span>
				</p>
			</div>
		</div>
	</div>
	<div class="mt-10">
		<h2 class="font-bold text-left py-2 text-xl">USP of <span x-text="ticket.type"></span></h2>
		<p x-text="ticket.type_copy" class="text-left text-gray-950 tracking-wider leading-8"></p>
	</div>
</section>