<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tickets</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
	<div class="w-full bg-gray-100 pb-20 py-10 grid md:grid-cols-4 md:gap-10 px-20">
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest pb-6 cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p>
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest pb-6 cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p>
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest pb-6 cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p>
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest pb-6 cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p>
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest pb-6 cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p>
			</div>
		</div>
	</div>
	<div class="w-full bg-gray-100 pb-20 py-10 grid md:grid-cols-4 md:gap-10 px-20">
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				{{-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p> --}}
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				{{-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p> --}}
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				{{-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p> --}}
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center pb-2">Name of the game</h2>
				{{-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p> --}}
			</div>
		</div>
		<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer" title="Click to view more information">
			<img src="{{ asset('images/games/talk.jpg') }}" alt="Image depicting the game" class="w-full h-auto">
			<div class="px-4 py-2">
				<h2 class="font-bold leading-9 text-center">Name of the game</h2>
				{{-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Iste quas soluta assumenda exercitationem animi corrupti laudantium omnis vel temporibus consequatur harum neque at quasi fuga aliquam ad deleniti tenetur, odio?</p> --}}
			</div>
		</div>
	</div>
</body>
</html>