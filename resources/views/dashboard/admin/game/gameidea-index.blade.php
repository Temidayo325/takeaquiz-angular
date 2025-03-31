@extends('layouts.admin')

@section('title', 'View all game ideas and suggestions')

@section('content')
	<style>
		
	</style>
	<div class="text-purple-1000 min-h-screen px-4 relative md:px-10 py-3 pb-20" 
			x-data='{ user: @json($user),
					games: @json($games),
                    suggestionForm: {idea: "", tags: "", game_id: ""},
					searchterm: "",
                    gameIndex: null,
					chosenGame: null,
					init(){
						
					},
					fetchData(cursor)
					{
						this.toast("Fetching data", "blue")
						try {
			                axios.post("/admin/dashboard/games/paginate", {cursor: cursor})
			                .then(response => {
			                	this.toast("Games successfully fetched", "green")
			                	this.games = response.data
			            	})
			                .catch( (error) => {
			                	this.toast(error.response.data.message, "red")
			                	console.log(error)
			                })
			            } catch (error) {
			                console.error(error)
			                this.toast("An error occured while trying to fetch data", "red")
			            }
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
					searchTerm()
					{
						this.toast("Searching for games having "+ this.searchTerm, "blue")
						axios.post("/admin/dashboard/games/search", {searchTerm: this.searchterm})
						.then( ( response ) => {
							if(!response.error)
							{
								this.toast("Search result returned successfully", "green")
								this.games = response.data.games
							}
						})
						.catch( (error) => {
							this.toast(error.response.data.messsage || "AN error while trying to search", "red")
						})
					},
                    deleteIdea(ideaId, index)
                    {
                        this.toast("Deleting game idea", "blue")
                        axios.post("/admin/dashboard/games/idea/delete", {idea_id: ideaId})
						.then( ( response ) => {
							if(!response.error)
							{
								this.toast("Idea deleted", "green")
								this.chosenGame.ideas.splice(index, 1)
                                this.games.data.splice(this.gameIndex, 1, this.chosenGame)
							}
						})
						.catch( (error) => {
							this.toast(error.data.messsage || "An error while trying to search", "red")
                            $refs.submitButton.disabled = false
						})
                    },
                    createSuggestion()
                    {
                        if(this.suggestionForm.idea.length < 2 || this.suggestionForm.tags.length < 3)
                        {
                            return false
                        }
                        this.toast("Creating suggestions", "blue")
                        $refs.submitButton.disabled = true
                        axios.post("/admin/dashboard/games/idea/create", this.suggestionForm)
						.then( ( response ) => {
							if(!response.error)
							{
								this.toast("Idea added to games succesfully", "green")
								this.chosenGame.ideas.unshift(response.data.idea)
                                this.games.data.splice(this.gameIndex, 1, this.chosenGame)
                                this.suggestionForm.tags = ""
                                this.suggestionForm.idea = ""
                                this.suggestionForm.game_id = ""
							}
						})
						.catch( (error) => {
							this.toast(error.data.messsage || "An error while trying to search", "red")
                            $refs.submitButton.disabled = false
						})
                    },
					viewGameDetails(game, index)
					{
                        this.gameIndex = index
						this.chosenGame = game
                        this.suggestionForm.game_id = this.chosenGame.id
						$refs.sideBarButton.dispatchEvent(new Event("click"))
					},
	}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-5">Each of the game idea/suggestions are tied to a specific game for easy grouping, so to reveal the ideas under each game, click the game card. To create a game idea, remeber to first create it's corresponding game.</p>
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
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-10 w-full max-w-6xl mx-auto my-20">
				<!-- Loop through cards -->
				<template x-for="(card, index) in games.data" :key="card.id">
				<div
					x-data=""
					class="relative w-full h-64 cursor-pointer"
				>
					<!-- Card Container -->
					<div
					class="absolute w-full h-full transition-transform duration-500 transform-style-preserve-3d"
					@click="viewGameDetails(card, index)"
					>
						<!-- Back Side -->
						<div class="absolute w-full h-full rounded-lg shadow-sm flex items-center justify-center backface-hidden transform rotate-y-180 text-purple-1000 ">
							<img src="{{ asset('images/cruise-back-gray.png') }}" alt="Image depicting the game" class="w-full h-full">
							<h2 x-text="card.name" class="absolute z-20 top-10 px-5 text-center font-bold"></h2>
							<div class="absolute z-20 bottom-10 text-center">
                                <p  class=" ">Game ideas</p>
                                <span x-text="card.ideas.length" class="mt-3 font-bold px-4"></span>
                            </div>
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
			<h2 class="text-center my-12 font-bold md:my-24 text-md">You have not created any games suggestions yet, Create more games to create game ideas</h2>
		</template>
		<x-sidebar-toggle-button></x-sidebar-toggle-button>
			
		<!-- drawer component -->
		<div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
			<button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
				<svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				<span class="sr-only">Close menu</span>
			</button>
			<div class="py-4 overflow-y-auto overflow-x-hidden text-black my-6 px-6">
				<template x-if="chosenGame != null">
					<div>
                        <form action="" method="post" @submit.prevent="createSuggestion()" class="">
                            <h2 class="text-left my-2 font-bold text-lg">Add new suggestion</h2>
                            
                            <div class="grid gap-6">
                                <div>
                                    <label for="idea" class="block text-gray-400 font-bold text-sm pb-2">Idea/Suggestions</label>
                                    <textarea required name="idea" id="idea" x-model="suggestionForm.idea" class="block w-full min-h-52"></textarea>
                                </div>
                                <div>
                                    <label for="tags" class="block font-bold text-gray-400 text-sm pb-2">Tags</label>
                                    <input required type="text" name="tags" id="tags" x-model="suggestionForm.tags" class="block w-full">
                                </div>
                                <button x-ref="submitButton" class="px-8 py-2 bg-purple-1000 text-gray-200 shadow disabled:bg-gray-400 disabled:text-gray-100">Add suggestion</button>
                            </div>                           
                        </form>
                        
                        <h2 class="text-left my-2 font-bold text-lg mt-10">Game ideas</h2>

                        <template x-if="chosenGame.ideas.length <= 0">
                            <h2 class="text-left my-4 text-md">You have not created any suggestions for this game yet</h2>
                        </template>

                        <template x-if="chosenGame.ideas.length > 0">
                            <ul class="grid gap-5">
                                <template x-for="(idea, index) in chosenGame.ideas" :id="idea.id">
                                    <li class="py-4 px-3 bg-gray-100 border border-gray-200 shadow rounded hover:shadow-xl">
                                        <h3 x-text="idea.question" class="font-bold"></h3>
                                        <p x-text="'Tags: '+idea.tags" class="py-2 text-gray-600"></p>
                                        <div class="flex justify-end">
                                            <button @click="deleteIdea(idea.id, index)" class="border-none underline text-red-800 text-right">Delete</button>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </template>
                    </div>
				</template>
			</div>
		</div>

		
	</div>

@endsection

