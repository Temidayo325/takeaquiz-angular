<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
	<title>Cruise deck</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" defer src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>
	<main class="bg-gray-100 pb-0">
		<header class="py-3 px-4 shadow-sm sticky top-0 bg-white shadow-sm md:px-12 flex justify-between items-center">
			<a href="/" class="flex justify-start items-center gap-2 py-2">
                <x-application-logo />
            </a>
            <ul class="flex justify-end gap-2 text-purple-1000 font-bold">
                <li><a href="/login" class="text-red-1000 px-3">Login</a></li>
            	<li><a href="/games">Cruise Deck</a></li>
            </ul>
		</header>
		<x-games.all-games :games="$games" :tags="$tags"></x-games.all-games>
	</main>
	<x-footer></x-footer>
</body>
</html>