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
		<header class="shadow-sm md:h-screen bg-black bg-cover bg-hero-bg bg-no-repeat tracking-wider md:overflow-hidden">
			<div class="sticky top-0 flex justify-between items-center py-3 px-4 md:py-7 md:px-12 bg-white z-80">
				<a href="/" class="flex justify-start items-center gap-2 ">
	                <x-application-logo class="fill-current text-purple-1000 " />
	                {{-- <h3 class="font-display tracking-widest font-bold text-lg text-purple-1000 ">CruiseHq</h3> --}}
	            </a>
	            <ul class="flex justify-end gap-2 md:gap-10 text-purple-1000 font-bold">
	                @guest
	                	<li><a href="/login" class="text-red-1000">Login</a></li>
	                @endguest
	                @auth
	                	<li><a href="/login" class="text-purple-1000">Dashboard</a></li>
	                @endauth
	                <li class="md:hidden">       	
						<button type="button"><svg class="w-10 h-6 text-purple-1000" id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" /></svg>

						</button>

						<!-- Dropdown menu -->
						<div id="dropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
						    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
						    	<li><a href="/plugs" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Plugs</a></li>
				            	<li><a href="/games" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cruise deck</a></li>
				            	<li><a href="/tools" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tools</a></li>
						</div>

	                </li>
	                <li class="hidden md:inline"><a href="/plugs" class="">Plugs</a></li>
	            	<li class="hidden md:inline"><a href="/games">Cruise deck</a></li>
	            	<li class="hidden md:inline"><a href="/tools">Tools</a></li>
	            </ul>
			</div>
			<div class="text-left text-purple-1000 py-2 px-4 md:px-20 md:py-10 grid gap-3 md:grid-cols-2 md:justify-center md:items-center my-10 md:my-24">
				<img src="{{asset('/images/hero-pacy.png')}}" alt="" class="md:h-[300px] md:w-[600px]" />
				<div class="mt-4 md:mt-0 mb-12 md:mb-0">
					<h1 class="text-4xl font-display md:text-[80px] mb-4 py-2 text-center md:text-left text-purple-900">Ahoy Cruiser<h1>
					<h3 class="font-body font-bold text-md leading-8">Welcome aboard CruiseHQ— your gateway to endless adventures and unforgettable moments. Here’s to creating memories that last a lifetime!</h3>
					<h5 class="md:mt-8 font-body font-bold">Smooth sailing,</h5>
					<h5 class="text-2xl mt-2 font-sign tracking-wider font-bold">TCG</h5>
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
					<p class="font-body">Request to become a promoter via your dashboard.</p>
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