<!DOCTYPE html>
<html>
<head>
    <title>Your Ticket Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <style>
		#ticket-container{
			background-image: url('https://cruisehq.fun/images/cruise-back-yellow.png'); 
			background-repeat: no-repeat; 
			background-size: 100% 100% ; 
			background-origin: center; 
			position: relative;
			padding: 40px 30px;
			text-align: left;
			margin: 0 auto;
			max-width: 250px;
		}
		.small-text
		{
			font-size: small;
			font-weight: light;
			color: gray;
		}
		div div > p
		{
			margin: 4px 0;
		}
		#grid-layout > div:nth-child(even)
		{
			text-align: right;
		}
    </style>
</head>
<body style="background-color: white; padding: 15px 10px;display: grid; justify-items: center; gap: 15px">
	<img src='https://cruisehq.fun/images/logo.png' alt="" style="width: 100px; height: 30px; margin: 10px auto">
	<div style="text-align: center">
		<h2 style="font-size: 2em; font-weight: bold">Dear Customer,</h2>
		<p style="font-size: 1.2em; text-align: center">OGs purchase ticket</p>
		<p>Your <em>{{$event->name}}</em> ticket details are below:</p>
		<p style="text-align: center; font-size: 1.1em;">{{ $ticket->name}} ticket</p>
		<div id="ticket-container">
            
			<div style="border-bottom: 2px solid black; text-align: center; font-weight: bold;">
				<h2 style="font-size: 2em;  padding:5px; ">{{ $event->name }}</h2>
				<p style="font-size: 1em; padding-bottom: 5px;">{{ $event->starting_time . " , " . ( new DateTime($event->event_date) )->format('D M d Y') }}</p>
			</div>
			<table role="presentation" width="100%" cellspacing="0" cellpadding="5" style="margin-top: 20px;">
				<tr>
					<td align="left">
						<p class="small-text">Ticket Owner</p>
						<p class="text-bold">{{ $user->nickname }}</p>
					</td>
					<td align="right">
						<p class="small-text">Organizer</p>
						<p class="text-bold">{{ $event->user->nickname }}</p>
					</td>
				</tr>
				<tr>
					<td align="left">
						<p class="small-text">Date</p>
						<p class="text-bold">{{ ( new DateTime($event->event_date) )->format('D M d Y') }}</p>
					</td>
					<td align="right">
						<p class="small-text">Time</p>
						<p class="text-bold">{{ $event->starting_time }}</p>
					</td>
				</tr>
				<tr>
					<td align="left">
						<p class="small-text">Location</p>
						<p class="text-bold">{{ $event->location }}</p>
					</td>
					<td align="right">
						<p class="small-text">State</p>
						<p class="text-bold">{{ $event->state }}</p>
					</td>
				</tr>
			</table>

			<div style="margin-top: 20px; text-align: center; margin-bottom: 30px; font-size: 1.8em; font-weight: bold;">
				<p>
					<span class="font-bold text-2xl">&#8358; </span>
					<span class="font-bold text-2xl"> {{ number_format($ticket->price, 0, '.', ',') }}</span>
				</p>
			</div>
		</div>
		<p style="text-align: left; padding: 10px;">This ticket can be presented as evidence of ticket purchase at the entry of the event</p>
		<p style="font-size: 1.5em; font-weight: bold;">Signed by TCG</p>
		<p style=" font-size: 1.2em; ">The Cruise god</p>
		<img src='https://cruisehq.fun/images/hero-pacy.png' alt="" style="width: 40px; height: 20px; margin: 10px auto">
	</div>
</body>
</html>
