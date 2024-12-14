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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" defer src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>
	<main class="bg-gray-100 pb-0">
		<header class="py-3 px-4 shadow-sm sticky top-0 bg-white shadow-sm md:px-12">
			<a href="/" class="flex justify-start items-center gap-2 py-2">
                <x-application-logo class="w-8 h-8 fill-current text-purple-1000" />
                <h3 class="font-display  font-bold text-lg text-purple-1000 tracking-widest">CruiseHq</h3>
            </a>
		</header>
		<x-games.all-games :games="$games" :tags="$tags"></x-games.all-games>
	</main>
	<x-footer></x-footer>
</body>
</html>