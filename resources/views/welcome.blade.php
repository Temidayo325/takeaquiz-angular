	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to CruiseHq</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
	<main class="bg-black">
		<header class="shadow-sm h-[92vh] md:h-[120vh] bg-black relative bg-contain md:bg-cover bg-hero3 md:bg-hero1 bg-no-repeat tracking-wider md:overflow-x-hidden">
			<div class="sticky top-0 flex justify-between items-center py-3 px-4 md:py-5 md:px-12 bg-white z-80">
				<a href="/" class="flex justify-start items-center gap-2 ">
	                <x-application-logo class="w-8 h-8 fill-current text-purple-1000 " />
	                <h3 class="font-display tracking-widest font-bold text-lg text-purple-1000 ">CruiseHq</h3>
	            </a>
	            <ul class="flex justify-end gap-2 text-purple-1000 font-bold">
	                <li><a href="/login" class="text-red-1000">Login</a></li>
	            	<li><a href="/games">Cruise deck</a></li>
	            </ul>
			</div>
			<div class="text-left text-gray-950 bg-white/30 md:bg-white/90 md:my-32 py-2 md:static px-4 md:w-3/6 md:px-12 md:py-10 absolute bottom-2 z-50">
				<h1 class="text-5xl font-display md:text-9xl py-2">Updates HQ<h1>
				<h3 class="font-body text-sm ">Welcome to CruiseHQ — the place where vibes and enjoyment are served hot. <span class="hidden md:inline">No stress, no wahala, just pure cruise! Are you ready to catch some sharp-sharp fun?</span></h3>
			</div>
		</header>
		<section class="text-greyish mt-10 md:mt-0">
			<x-event.calender :events="$events" :events_today="$events_today" :premium_events="$premium_events" class="text-greyish"></x-event.calender>
		</section>
		<section class="py-4 pb-10 px-4 md:px-10 bg-lightpurple md:bg-purple-200 tracking-wider md:pb-24 md:pt-12">
			<h2 class="font-display text-6xl py-6 pb-12">Planning an event? Become an event organizer in just 3 super simple steps!</h2>
			<div class="grid gap-6 md:grid-cols-3">
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">01</h4>
					<p>Create an account using the registration form on the website</p>
				</div>
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">02</h4>
					<p>Reach out to the admin via any of the channels provided below or on your dashboard to upgrade your account to an organizer's account.</p>
				</div>
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">03</h4>
					<p>Create your own events and craft your tickets</p>
				</div>
			</div>
		</section>
	</main>
	<x-footer></x-footer>
</body>
</html>