<section 	class="grid gap-6 text-purple-1000" 
			x-data='{ event: {
				id: 13, user_id: 1, name: "Buju Phenomena gathering", state: "Lagos", starting_time: "04:11:24", event_date: "2024-11-25"}, 
				ticket: {price: 0, type_copy: "", total_seat: 0, available_seat: 0, type: ""},
				user: JSON.parse(localStorage.getItem("user")),
				ticket: JSON.parse(sessionStorage.getItem("ticket")),
				init()
				{
					console.log(this.chosenEvent)
				}
			}'
			x-modelable="event"
			x-model="chosenEvent"
>
	{{-- <div>
		<h2 class="text-center font-bold ">Early bird ticket (at point of purchase)</h2>
		<div>
			
		</div>
	</div> --}}
	<div class="w-48 md:w-64 bg-white px-4 py-10 pb-5 rounded mt-2 text-center border border-gray-200 shadow-md hover:shadow-lg font-body">
		<div>
			<div class="border-b border-black">
				<h2 class="text-3xl font-bold" x-text="chosenEvent.name"></h2>
				<p class="text-sm font-bold py-2" x-text="chosenEvent.starting_time + ' ,' + chosenEvent.event_date"></p>
			</div>
			<div class="grid grid-cols-2 gap-6 text-left mt-5">
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Ticket owner</p>
					<p class="font-bold text-purple-1000" x-text="user.nickname">CruiseHq</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Promoter</p>
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
				<p>Price : 
					<span class="font-bold text-2xl">&#8358; </span>
					<span class="font-bold text-2xl" x-text="new Intl.NumberFormat().format(ticket.price)"></span>
				</p>
			</div>
		</div>
	</div>
	<div class="mt-12">
		<h2 class="font-bold text-left py-2 text-md">USP of <span x-text="ticket.type"></span></h2>
		<p x-text="ticket.type_copy" class="text-left text-gray-950 text-sm tracking-wider leading-8"></p>
	</div>
</section>