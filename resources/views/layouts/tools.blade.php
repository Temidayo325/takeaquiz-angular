<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<title>@yield('title',"CruiseHq tools for games")</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
	<style>
		header{
			z-index: 1000 !important;
		}
	</style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
	
</head>
<body>
	<header class="shadow-sm z-50">
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
	</header>
	<main class="bg-gray-200 px-4 md:px-10 py-6">
		@yield('content')
	</main>
	<x-footer></x-footer>
</body>
</html>