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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
	<header class="shadow-sm">
		<div class="sticky top-0 flex justify-between items-center py-3 px-4 md:py-7 md:px-12 bg-white z-80">
			<a href="/" class="flex justify-start items-center gap-2 ">
                <x-application-logo class="fill-current text-purple-1000 " />
                {{-- <h3 class="font-display tracking-widest font-bold text-lg text-purple-1000 ">CruiseHq</h3> --}}
            </a>
            <ul class="flex justify-end gap-2 md:gap-10 text-purple-1000 font-bold">
                <li><a href="/login" class="text-red-1000">Login</a></li>
                <li><a href="/plugs" class="">Plugs</a></li>
            	<li><a href="/games">Cruise deck</a></li>
            </ul>
		</div>
	</header>
	<main class="bg-gray-200 px-4 md:px-10 py-6">
		@yield('content')
	</main>
	<x-footer></x-footer>
</body>
</html>