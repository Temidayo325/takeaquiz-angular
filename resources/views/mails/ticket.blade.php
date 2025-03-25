<!DOCTYPE html>
<html>
<head>
    <title>Your Ticket Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    </style>
</head>
<body class="relative w-full  max-w-md mx-auto p-4">
<div class="body px-4 absolute inset-0 bg-no-repeat bg-center bg-cover rounded-2xl ">
        <img src='{{ asset("images/logo.png")}}' alt="" class="w-28 h-12 mx-auto mt-10 mb-3">
		<div class="bg-gray-400 px-4 py-10 pb-5 rounded mt-4 text-center border border-gray-200 shadow-md hover:shadow-lg font-body">
            <p class="font-bold text-purple-1000">{{ $ticket->name}}</p>
			<div class="border-b border-black">
				<h2 class="text-3xl font-bold">{{ $event->name }}</h2>
				<p class="text-sm font-bold py-2">{{ $event->starting_time . " ," . $event->event_date }}</p>
			</div>
			<div class="grid grid-cols-2 gap-6 text-left mt-5">
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Ticket owner</p>
					<p class="font-bold text-purple-1000">{{ $user->nickname}}</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Organizer</p>
					<p class="font-bold text-purple-1000">{{ $event->user->nickname }}</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Date</p>
					<p class="font-bold text-purple-1000">{{ ( new DateTime($event->event_date) )->format('D M d Y') }}</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Time</p>
					<p class="font-bold text-purple-1000">{{ $event->starting_time }}</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-gray-600 text-sm">Location</p>
					<p class="font-bold text-purple-1000">{{ $event->location }}</p>
				</div>
				<div class="pb-3 border-b border-gray-300">
					<p class="text-greyish text-sm">State</p>
					<p class="font-bold">{{ $event->state}}</p>
				</div>
			</div>
			<div class="mt-10 text-purple-1000">
				<p>Price : 
					<span class="font-bold text-2xl">&#8358; </span>
					<span class="font-bold text-2xl"> {{ number_format($ticket->price, 0, '.', ',') }}</span>
				</p>
			</div>
		</div>
	</div>
</body>
</html>
