@extends('layouts.admin')

@section('title', 'View all games')

@section('content')
	<style>
		.transform-style-preserve-3d {
		transform-style: preserve-3d;
		}
		.backface-hidden {
		backface-visibility: hidden;
		}
		.rotate-y-180 {
		transform: rotateY(180deg);
		}
	</style>
	<div class="text-purple-1000 min-h-screen px-4 relative md:px-10 py-3 pb-20" 
			x-data='{ user: @json($user),
					games: @json($games),
					searchterm: "",
					chosenGame: null,
					init(){
						
					},
					fetchData(cursor)
					{
						this.toast("Fetching data", "white", "blue")
						try {
			                axios.post("/admin/dashboard/games/paginate", {cursor: cursor})
			                .then(response => {
			                	this.toast("Games successfully fetched", "white", "green")
			                	this.games = response.data
			            	})
			                .catch( (error) => {
			                	this.toast(error.response.data.message, "white", "red")
			                	console.log(error)
			                })
			            } catch (error) {
			                console.error(error)
			                this.toast("An error occured while trying to fetch data", "white", "red")
			            }
					},
					toast(text, color, background)
					{
    					Toastify({
						  text: text, 
						  style: {
						    background: background,
						    color: color
						  }
						}).showToast();
    				},
					searchTerm()
					{
						this.toast("Searching for games having "+ this.searchTerm, "white", "blue")
						axios.post("/admin/dashboard/games/search", {searchTerm: this.searchterm})
						.then( ( response ) => {
							if(!response.error)
							{
								this.toast("Search result returned successfully", "white", "green")
								this.games = response.data.games
							}
						})
						.catch( (error) => {
							this.toast(error.response.data.messsage || "AN error while trying to search", "white", "red")
						})
					},
					viewGameDetails(game)
					{
						this.chosenGame = game
						$refs.sideBarButton.dispatchEvent(new Event("click"))
					},
	}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">View all the available games, to view more details about the game, click on the game card and a sidebar would pop out revealing more information ablut the game. Click the button below to create more games</p>
				<a href="/admin/dashboard/games/create" class="px-6 py-3 font-bold md:font-normal bg-red-1000 text-gray-200">Create game</a>
			</div>
			<img src="{{asset('/images/games.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="w-full mt-10 md:mt-20 flex justify-end mb-5" x-show="games.data.length > 0 ">
			<div>
				<form action="" method="" class="flex justify-end " @submit.prevent="searchTerm()">
					@csrf
					<input type="text" class="w-full md:w-72 p-2" placeholder="name of game goes here e.g. Spin the bottle" x-model="searchterm" @input.debounce.500ms="searchTerm">
					<button class="bg-gray-950 text-gray-200 px-5 py-2">Search</button>
				</form>
			</div>
		</div>
		<template x-if="games.data.length > 0 " class="">
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 w-full max-w-6xl mx-auto">
				<!-- Loop through cards -->
				<template x-for="card in games.data" :key="card.id">
				<div
					x-data="{ isFlipped: false }"
					@mouseenter="isFlipped = true"
					@mouseleave="isFlipped = false"
					class="relative w-full h-96 cursor-pointer"
				>
					<!-- Card Container -->
					<div
					:class="{ 'transform rotate-y-180': isFlipped }"
					class="absolute w-full h-full transition-transform duration-500 transform-style-preserve-3d"
					@click="viewGameDetails(card)"
					>
						<!-- Front Side -->
						<div class="absolute w-full h-full rounded-lg shadow-sm flex items-center justify-center backface-hidden">
							<img src="{{ asset('images/cruisehq-frontcard.png') }}" alt="Image depicting the game" class="w-full h-full">
						</div>
						<!-- Back Side -->
						<div class="absolute w-full h-full rounded-lg shadow-sm flex items-center justify-center backface-hidden transform rotate-y-180 text-purple-1000 ">
							<img src="{{ asset('images/cruise-back-gray.png') }}" alt="Image depicting the game" class="w-full h-full">
							<h2 x-text="card.name" class="absolute z-20 top-2 left-3 px-5 text-center font-bold"></h2>
						</div>
					</div>
				</div>
				</template>
			</div>
			<div class="flex justify-end gap-10 my-4">
				<template x-if="games.prev_cursor != null">
					<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(games.prev_cursor)" >Prev</button>
				</template>
				<template x-if="games.next_cursor != null">
					<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(games.next_cursor)">Next</button>
				</template>
			</div>

		</template>
		
		<template x-if="games.data.length <= 0">
			<h2 class="text-center my-12 font-bold md:my-24 text-xl">You have not created any games yet, Click <a href="/admin/dashboard/games/create" class="text-red-1000"> here </a>  to add some games</h2>
		</template>
		<x-sidebar-toggle-button></x-sidebar-toggle-button>
			
		<!-- drawer component -->
		<div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
			<button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
				<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				<span class="sr-only">Close menu</span>
			</button>
			<div class="py-4 overflow-y-auto overflow-x-hidden text-black my-10">
				<template x-if="chosenGame != null">
					<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer pb-10" title="Click to view more information" >
						<!-- <img src="{{ asset('images/cruisehq-frontcard.png') }}" alt="Image depicting the game" class="w-full h-auto"> -->
						<div class="px-4 py-2">
							<h2 class="font-bold leading-9 text-center mb-4 text-lg" x-text="chosenGame.name">Name of the game</h2>
							<h4 class="font-bold text-md">Game summary</h4>
							<p x-text="chosenGame.summary"></p>
							<p class="mt-4">
								<strong>Minimum required players : </strong>
								<span x-text="chosenGame.minimum_player"></span>
							</p>
							<p class="mt-2">
								<strong>Maximum required players : </strong>
								<span x-text="chosenGame.maximum_player"></span>
							</p>
							
							<div>
								<h4 class="mt-4 font-bold text-md">How to play</h4>
								<ul class="mt-2 px-10 py-2">
									<template x-for="step in chosenGame.stepByStep" class="">
										<li x-text="step" class="list-decimal py-1"></li>
									</template>
								</ul>

								<h4 class="mt-4 font-bold text-md">Required Materials or Setup</h4>
								<ul class="mt-2 px-10 py-2">
									<template x-for="material in chosenGame.materials" class="">
										<li x-text="material" class="list-decimal py-1 wrap"></li>
									</template>
								</ul>

								<h4 class="mt-4 font-bold text-md">Estimated Playtime</h4>
								<p x-text="chosenGame.play_time" class="text-sm leading-8"></p>

								<h4 class="mt-4 font-bold text-md">Difficulty Level</h4>
								<p x-text="chosenGame.difficulty_level" class="text-sm leading-8"></p>

								<h4 class="mt-4 font-bold text-md">Player Category</h4>
								<p x-text="chosenGame.category" class="text-sm leading-8"></p>

								<h4 class="mt-4 font-bold text-md">Ideal setting</h4>
								<p x-text="chosenGame.ideal_setting" class="text-sm leading-8"></p>

								<h4 class="mt-4 font-bold text-md">Objective or Win Condition</h4>
								<p x-text="chosenGame.objective" class="text-sm leading-8"></p>

								<h4 class="mt-4 font-bold text-md">Tips for Success</h4>
								<p x-text="chosenGame.tips" class="text-sm leading-8"></p>										
							</div>
						</div>
					</div>
				</template>
			</div>
		</div>

		
	</div>

@endsection

