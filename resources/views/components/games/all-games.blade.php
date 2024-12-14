@props(['games', 'tags'])
<div 	class="text-purple-1000 px-4 md:px-12" 
			x-data='{ games: @json($games),
					tags: @json($tags),
					searchterm: "",
					chosenGame: null,
					init(){
						console.log(this.tags)
					},
					fetchData(cursor)
					{
						this.toast("Fetching more games ...", "blue")
						try {
			                axios.post("/admin/dashboard/games/paginate", {cursor: cursor})
			                .then(response => {
			                	this.toast("Games retrieved successfully", "green")
			                	this.games = response.data
			            	})
			                .catch((error) => {
			                	this.toast("Encountered an error while retrieving games", "red")
			            	})
			            } catch (error) {
			                this.toast("Encountered an error while retrieving games", "red")
			            }
					},
					searchTerm()
					{
						this.toast("Searching for games ... ", "blue")
						axios.post("/admin/dashboard/games/search", {searchTerm: this.searchterm})
						.then( ( response ) => {
							if(!response.error)
							{
								this.games = response.data.games
								this.toast("Games returned", "green")
							}
						})
						.catch((error) => {
							this.toast("Encountered an error while retrieving games", "red")
						})
					},
					searchByTag(tag)
					{
						this.toast("Searching for games with " + tag + " tag ... ", "blue")
						axios.post("/games/search/tag", {tag: tag})
						.then( ( response ) => {
							if(!response.error)
							{
								this.games = response.data.games
								this.toast("Games with " + tag + " tags returned", "green")
							}
						})
						.catch((error) => {
							this.toast("Encountered an error while retrieving games", "red")
						})
					},
					viewGameDetails(game)
					{
						this.chosenGame = game
						$refs.sideBarButton.dispatchEvent(new Event("click"))
					},
					toast(text, background)
					{
						Toastify({
						  text: text, 
						  style: {
						    background: background,
						    color: "white"
						  }
						}).showToast();
					},
	}'>
		<div class="mt-6">
			<div class="py-7 px-2 text-purple-1000 bg-gamebar bg-cover bg-no-repeat bg-greyish bg-blend-multiply md:h-56">
				<h1 class=" text-6xl font-normal font-display md:py-12 text-white/70 px-5 py-3">Fun party games!!</h1>
				{{-- <p class="mt-3 text-md bg-white/50 px-5 py-3">We curated some games to light up your gatherings and events</p> --}}
			</div>
			<div class="mt-8">
				<h1 class="font-bold font-body text-md mt-4 md:hidden">Popular game tags</h1>
				<div class="flex gap-6 justify-start items-center overflow-x-scroll py-6 px-3">
					<template x-for="tag in tags">
						<button x-text="tag" class="rounded-full no-wrap px-8 py-2 shadow-lg text-nowrap bg-purple-1000 text-gray-200" @click="searchByTag(tag)"></button>
					</template>
				</div>
			</div>
			<h1 class="font-bold font-body text-md mt-4 md:hidden">View available games</h1>
			<div class="mt-2 md:mt-12">
				<form action="" method="" class="flex justify-start " @submit.prevent="searchTerm()">
					@csrf
					<input type="text" class="w-full text-sm px2 py-1 md:py-2 focus:outline-0 focus:border-lightpurple focus:ring-0 md:w-2/6" x-model="searchterm" placeholder="e.g. spin the bottle" @input.debounce.500ms="searchTerm">
					{{-- <button class="bg-gray-950 text-gray-200 px-6 py-2">Search</button> --}}
				</form>
			</div>
		</div>
		<div>
			<template x-if="games.data.length > 0 ">
				<div >
					<div class="w-full pb-10 py-10 grid grid-cols-2 gap-x-3 gap-y-10 md:grid-cols-4 md:gap-10">
						<template x-for="game in games.data">
							<button class="hover:shadow-xl hover:border-2 hover:border-gray-300 hover:transition-border game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer" title="Click to view more information" @click="viewGameDetails(game)">
								<img :src="`{{ asset('.') }}${game.image}`" alt="Image depicting the game" class="w-full h-32">
								<div class="px-2 py-1 text-sm">
									<h2 class="font-bold text-center" x-text="game.name">Name of the game</h2>
									<p>
										<span>Min:<span class="font-bold" x-text="game.minimum_player"></span></span>
										<span>Max:<span class="font-bold" x-text="game.maximum_player"></span></span>
									</p>
								</div>
							</button>
						</template>
					</div>
					<div class="flex justify-end gap-10 my-1 pb-20">
						<template x-if="games.prev_cursor != null">
							<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(games.prev_cursor)" >Prev</button>
						</template>
						<template x-if="games.next_cursor != null">
							<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(games.next_cursor)">Next</button>
						</template>
					</div>
				</div>
			</template>
			<template x-if="games.data.length <= 0">
				<h2>You have not created any games yet, Click here to add some games</h2>
			</template>
			<x-sidebar-toggle-button></x-sidebar-toggle-button>
			  
			<!-- drawer component -->
		    <div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
		        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
		            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
		            <span class="sr-only">Close menu</span>
		        </button>
		        <div class="py-4 overflow-y-auto text-black my-10">
					<template x-if="chosenGame != null">
						<div class="game-card-ui shadow border border-gray-200 w-full bg-white text-gray-950 tracking-widest cursor-pointer pb-10" title="Click to view more information" >
							<img :src="`{{ asset('.') }}${chosenGame.image}`" alt="Image depicting the game" class="w-full h-auto">
							<div class="px-4 py-2">
								<h2 class="font-display leading-9 text-center mb-4" x-text="chosenGame.name">Name of the game</h2>
								<h4 class="font-bold text-md">Game summary</h4>
								<p x-text="chosenGame.summary" class="text-sm leading-8"></p>
								<p class="mt-4">
									<strong>Min players : </strong>
									<span x-text="chosenGame.minimum_player"></span>
								</p>
								<p class="mt-2">
									<strong>Max players : </strong>
									<span x-text="chosenGame.maximum_player"></span>
								</p>
								<h4 class="mt-8 font-bold text-md">How to play game</h4>
								<p x-text="chosenGame.stepByStep" class="text-sm leading-8"></p>
							</div>
						</div>
					</template>
		        </div>
		    </div>
		</div>
	</div>