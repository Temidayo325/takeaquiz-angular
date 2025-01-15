@extends('layouts.tools')

@section('title', 'CruiseHq tools for your games and downtimes')

@section('content')
	<section x-data='{tools: [
		{image: "images/tools/stopwatch.jpg", url: "/tools/timer", name: "Timer / Stopwatch", summary: "Our stopwatch tool allows you to measure the amount of time that elapses between its activation and deactivation. This will be useful for your time-based challenges and games at your next gathering"}, 
		{image: "images/tools/coin-flip.jpg", url: "/tools/coin-flip", name: "Coin flip", summary: "Our Coin flip tool provides you with a simple digital coin flip use case. This will be useful for your coin-based challenges and games at your next gathering"},
		{image: "images/tools/spin-the-bottle.jpg", url: "/tools/spin-the-bottle", name: "Spin-the-bottle", summary: "Our spin-the-bottle tool provides you with a simple digital bottle spinner use case. This will be useful for your spin-the-bottle-based challenges and games at your next gathering"},
		]}' class="text-purple-1000">
		<header class="mb-6">
			<h1 class="font-bold font-display text-4xl md:text-6xl md:max-w-3xl md:leading-12 py-3 tracking-wide">We've curated the tools to make your next gathering fun and memorable</h1>
		</header>
		<div class="w-full pb-10 py-10 grid grid-cols-2 gap-x-3 gap-y-10 md:grid-cols-5 md:gap-10">
			<template x-for="tool in tools">
				<a class="hover:shadow-xl hover:border-2 hover:border-gray-300 shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer grid justify-start" title="Click to view more information" :href="tool.url">
					<img :src="`{{ asset('.') }}/${tool.image}`" alt="Image depicting the tool" class="w-full h-38">
					<div class="px-2 py-1 text-sm">
						<h2 class="font-bold text-center md:text-lg py-2" x-text="tool.name"></h2>
						<p>
						</p>
					</div>
				</a>
			</template>
		</div>
	</section>

@endsection