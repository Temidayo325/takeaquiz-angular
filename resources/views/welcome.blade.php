	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
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
		<header class="shadow-sm md:h-[100vh] bg-black bg-cover bg-hero-bg bg-no-repeat tracking-wider md:overflow-hidden">
			<div class="sticky top-0 flex justify-between items-center py-3 px-4 md:py-7 md:px-12 bg-white z-80">
				<a href="/" class="flex justify-start items-center gap-2 ">
	                <x-application-logo class="fill-current text-purple-1000 " />
	                {{-- <h3 class="font-display tracking-widest font-bold text-lg text-purple-1000 ">CruiseHq</h3> --}}
	            </a>
	            <ul class="flex justify-end gap-2 md:gap-10 text-purple-1000 font-bold">
	                <li><a href="/login" class="text-red-1000">Login</a></li>
	            	<li><a href="/games">Cruise deck</a></li>
	            </ul>
			</div>
			<div class="text-left text-purple-1000 py-2 px-4 md:px-20 md:py-10 grid gap-3 md:grid-cols-2 md:items-center my-10 md:my-20">
				<img src="{{asset('/images/hero-pacy.png')}}" alt="" class="md:h-[300px] md:w-[600px]">
				<div class="mt-4 md:mt-0 mb-12 md:mb-0">
					<h1 class="text-4xl font-display md:text-[80px] mb-4 py-2 text-center md:text-left text-purple-900">Ahoy Cruiser<h1>
					<h3 class="font-body text-md leading-8">Welcome aboard CruiseHQ— your gateway to endless adventures and unforgettable moments. Here’s to creating memories that last a lifetime!</h3>
					<h5 class="md:mt-8 font-body">Smooth sailing,</h5>
					<h5 class="text-2xl mt-2 font-sign tracking-wider">TCG</h5>
				</div>
			</div>
		</header>
		<section class="text-greyish mt-10 md:mt-0">
			<x-event.calender :events="$events" :events_today="$events_today" :premium_events="$premium_events" class="text-greyish"></x-event.calender>
		</section>
		<section class="py-4 pb-10 px-4 md:px-10 bg-lightpurple md:bg-purple-200 tracking-wider md:pb-24 md:pt-12">
			<h2 class="font-display text-6xl py-6 pb-12 md:w-6/12">Planning an event? Become an event organizer in just 3 super simple steps!</h2>
			<div class="grid gap-6 md:grid-cols-3">
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">01</h4>
					<p class="font-body">Create an account using the registration form on the website</p>
				</div>
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">02</h4>
					<p class="font-body">Reach out to the admin via any of the channels provided below or on your dashboard to upgrade your account to an organizer's account.</p>
				</div>
				<div class="bg-gray-200 p-3 rounded shadow-md">
					<h4 class="font-display text-purple-1000 mb-2 text-6xl">03</h4>
					<p class="font-body">Create your own events and craft your tickets</p>
				</div>
			</div>
		</section>
	</main>
	<x-footer></x-footer>
</body>
</html>