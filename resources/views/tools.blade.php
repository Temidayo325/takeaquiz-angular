@extends('layouts.tools')

@section('title', 'CruiseHq tools for your games and downtimes')

@section('content')
	<section x-data='{tools: [
		{id:1, image: "images/tools/stopwatch.jpg", url: "/tools/timer", name: "Timer / Stopwatch", summary: "Our stopwatch tool allows you to measure the amount of time that elapses between its activation and deactivation. This will be useful for your time-based challenges and games at your next gathering"}, 
		{id: 2, image: "images/tools/coin-flip.jpg", url: "/tools/coin-flip", name: "Coin flip", summary: "Our Coin flip tool provides you with a simple digital coin flip use case. This will be useful for your coin-based challenges and games at your next gathering"},
		{id: 3, image: "images/tools/spin-the-bottle.jpg", url: "/tools/spin-the-bottle", name: "Spin-the-bottle", summary: "Our spin-the-bottle tool provides you with a simple digital bottle spinner use case. This will be useful for your spin-the-bottle-based challenges and games at your next gathering"},
		]}' class="text-purple-1000">
		<header class="mb-6">
			<h1 class="font-bold font-display text-4xl md:text-6xl md:max-w-3xl md:leading-12 py-3 tracking-wide">We've curated the tools to make your next gathering fun and memorable</h1>
		</header>
		<div class="mt-10 md:mt-20 mb-10 md:mb-20 grid justify-start grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-10 w-full max-w-7xl ">
			<!-- Loop through cards -->
			<template x-for="tool in tools" :key="tool.id">
			<div
				class="relative w-full h-72 cursor-pointer"
			>
				<!-- tool Container -->
				<a
				class="z-20 absolute w-full h-full transition-transform duration-500 transform-style-preserve-3d"
				:href="tool.url"
				>
					<!-- Back Side -->
					<div class="absolute w-full h-full rounded-lg shadow-sm flex items-center justify-center backface-hidden transform rotate-y-180 text-purple-1000 ">
						<img src="{{ asset('images/cruise-back-gray.png') }}" alt="Image depicting the game" class="w-full h-full">
						<h2 x-text="tool.name" class="absolute top-[50%] px-5 text-center font-bold"></h2>
					</div>
				</a>
			</div>
			</template>
		</div>
	</section>
@endsection