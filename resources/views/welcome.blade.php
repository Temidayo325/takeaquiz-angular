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
	<main class="bg-black pb-0 ">
		<header class="py-3 px-4 md:px-10 shadow-sm bg-hero bg-purple-950 bg-blend-overlay h-[90vh] bg-cover tracking-wider">
			<a href="/" class="sticky top-0 flex justify-start items-center gap-2 py-2">
                <x-application-logo class="w-8 h-8 fill-current text-lightpurple" />
                <h3 class="font-display  font-bold text-md text-lightpurple">CruiseHq</h3>
            </a>
			<div class="my-24 text-center text-lightpurple">
				<h1 class="text-7xl font-display  py-2">Updates HQ<h1>
				<h3 class="font-body text-md ">Welcome to CruiseHQ — the place where vibes and enjoyment are served hot. No stress, no wahala, just pure cruise! Are you ready to catch some sharp-sharp fun?</h3>
			</div>
		</header>
		<section class="text-greyish">
			<x-event.calender :events="$events" :events_today="$events_today" :premium_events="$premium_events" class="text-lightpurple"></x-event.calender>
		</section>
		<section class="py-4 pb-10 px-4 md:px-10 bg-lightpurple tracking-wider">
			<h2 class="font-display text-6xl py-6 pb-12">Become a promoter in 3 easy steps</h2>
			<div class="grid gap-6">
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">01</h4>
					<p>Create an account using using the registration form on the website</p>
				</div>
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">02</h4>
					<p>Reach out to the admin via any of the channels provided below or on your dashboard to upgrade your account to a promoter account.</p>
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