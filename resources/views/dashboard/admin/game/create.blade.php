@extends('layouts.admin')

@section('title', 'Create fun games')

@section('content')
	<div class="text-black px-10 md:pb-20" x-data='{ user: @json($user),
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
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
	}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200 ">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Create awesome and fun games</h1>
				<p class="text-md leading-7 my-4">Create amazing games and ensure to provide adequate details to it. Also don't forget to add correct tags to it to ensure that it shows up in the right category</p>
				<a href="/admin/dashboard/games" class="px-5 py-3 font-bold md:font-normal bg-red-1000 text-gray-200">View games</a>
			</div>
			<img src="{{asset('/images/games.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="mt-12">
			<h1 class="text-center mt-6 mb-2 font-display tracking-wider text-2xl">Create an amazing game</h1>
			<form action="" 

						method="post"
						x-ref="form"
						@submit.prevent="submitForm()" 
						x-data='{ data: { name: "", summary: "", stepByStep: [], minimum_player: "", maximum_player: "", image: "", tags: "", "materials": "", "play_time": "", "difficulty_level": "", "category": "", "ideal_setting": "", "objective": "", "tips": "" }, 
						error: false,
						errorMessage: "",
						steps: [],
						submitForm(){
							this.toast("Creating games", "white", "blue")
							let formdata = new FormData($refs.form)
							formdata.append("stepByStepJson", JSON.stringify(this.steps));
							axios.post("/admin/dashboard/games/create", formdata)
							.then( ( response ) => {
								this.toast("Games created successfully, click on the View games button to view all games", "white", "green")
								this.data = { name: "", summary: "", stepByStep: "", minimum_player: "", maximum_player: "", image: "", tags: "" }
								this.error = false
								this.steps = []
							})
							.catch( (error) => {
								console.log(error)
								this.toast(error.response.data.message, "white", "red")
							})
						},
						addStep()
						{
							this.steps.push(this.data.stepByStep)
							this.data.stepByStep = ""
						}
					}'
						class="mx-auto md:w-full border border-gray-100 shadow-md px-6 py-5 grid md:overflow-x-hidden md:grid-cols-2 gap-x-6 gap-y-10 bg-gray-100 md:bg-white pb-8 shadow-2xl mt-10">
				<div class="my-2">
					<label for="name" class="font-bold text-gray-950">Name of the game</label>
					<p class="text-gray-600 text-sm ">Most popular name of the game</p>
					<input type="text" name="name" id="name" required="required" minLength="5" x-model="data.name" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>
				@csrf
				<div class="my-2">
					<label for="summary" class="font-bold text-gray-950">Summary of the game</label>
					<p class="text-gray-600 text-sm ">Provide a brief description of the game's concept and objective.</p>
					<textarea name="summary" id="summary" required="required" minLength="5" x-model="data.summary" class="focus:outline-0 focus:shadow-lg focus:border-none w-full min-h-56"></textarea>
				</div>

				<div class="my-2">
					<label for="stepByStep" class="font-bold text-gray-950">How to Play the Game</label>
					<p class="text-gray-600 text-sm ">Step-by-step instructions on setting up and playing the game, mentioning any rules or special conditions.</p>
					<textarea name="stepByStep" id="stepByStep" minLength="5" x-model="data.stepByStep" class="min-h-24 focus:outline-0 focus:shadow-lg focus:border-none w-full"></textarea>
					<button type="button" class="px-6 py-2 bg-purple-1000 text-white" title="Click the button to add to the step by step list" @Click="addStep()">Add step</button>
					<ul class="mt-2 px-10 py-2">
						<h3 class="text-center font-bold ">Step by step guide to playing the game</h3>
						<template x-for="step in steps" class="">
							<li x-text="step" class="list-decimal py-1"></li>
						</template>
					</ul>
				</div>
				<div class="my-2">
					<label for="tags" class="font-bold text-gray-950">Game tags</label>
					<p class="text-gray-600 text-sm ">List relevant tags or categories (e.g., “outdoor,” “team-building,” “board game,” “party,” etc.).</p>
					<input type="text" name="tags" id="tags" required="required" minLength="5" x-model="data.tags" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>
				<div class="">
					<label for="minimum_player">Minimum number of players</label>
					<p class="text-gray-600 text-sm ">State the minimum number of players required.</p>
					<input type="tel" name="minimum_player" id="minimum_player" required x-model="data.minimum_player">
				</div>
				<div class="">
					<label for="maximum_player">Maximum number of players</label>
					<p class="text-gray-600 text-sm ">State the maximum number of players allowed (or "unlimited" if applicable).</p>
					<input type="text" name="maximum_player" id="maximum_player" required x-model="data.maximum_player">
				</div>		
				<div class="">
					<label for="picture">Game image</label>
					<p class="text-gray-600 text-sm ">Include or attach an image representing the game (e.g., a photo, icon, or illustration).</p>
					<input type="file" name="picture" id="picture" required x-ref="picture">
				</div>
				<div class="my-2">
					<label for="materials" class="font-bold text-gray-950">Game materials</label>
					<p class="text-gray-600 text-sm ">List all items or setup required to play the game. Separate each material with a comma</p>
					<textarea name="materials" id="materials"  required="required" minLength="5" x-model="data.materials" class="min-h-56 focus:outline-0 focus:shadow-lg focus:border-none w-full"></textarea>
				</div>
				<div class="my-2">
					<label for="play_time" class="font-bold text-gray-950">Estimated Playtime</label>
					<p class="text-gray-600 text-sm ">State how long a typical game session lasts.</p>
					<input type="text" name="play_time" id="play_time" required="required" minLength="5" x-model="data.play_time" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>
				<div class="my-2">
					<label for="difficulty_level" class="font-bold text-gray-950">Difficulty Level</label>
					<p class="text-gray-600 text-sm ">Rate as Easy, Moderate, or Challenging.</p>
					<select name="difficulty_level" id="difficulty_level" x-model="data.difficulty_level">
						<option value="Easy">Easy</option>
						<option value="Moderate">Moderate</option>
						<option value="Challenging">Challenging</option>
					</select>
				</div>
				
				<div class="my-2">
					<label for="tips" class="font-bold text-gray-950">Tips</label>
					<p class="text-gray-600 text-sm ">Hint: Hashtags for the game</p>
					<input type="text" name="tips" id="tips" required="required" minLength="5" x-model="data.tips" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>

				<div class="my-2">
					<label for="ideal_setting" class="font-bold text-gray-950">Ideal Setting</label>
					<p class="text-gray-600 text-sm ">Mention where the game is best played (e.g., indoors, outdoors, small space, large area).</p>
					<input type="text" name="ideal_setting" id="ideal_setting" required="required" minLength="5" x-model="data.ideal_setting" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>
				<div class="my-2">
					<label for="objective" class="font-bold text-gray-950">Objective or Win Condition</label>
					<p class="text-gray-600 text-sm ">Describe the goal or what constitutes winning the game.</p>
					<input type="text" name="objective" id="objective" required="required" minLength="5" x-model="data.objective" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>
				
				<div class="my-2">
					<label for="category" class="font-bold text-gray-950">Player Category</label>
					<select name="category" id="category" required="required" x-model="data.category">
						<option value="All Ages">All Ages (suitable for everyone)</option>
						<option value="Kids">Kids (primarily for children)</option>
						<option value="Teens">Teens (focused on teenage players)</option>
						<option value="Adults">Adults (general adult audience)</option>
						<option value="NSFW">NSFW (not safe for work or age-restricted content)</option>
					</select>
				</div>
				<button type="submit" class="px-6 py-3 bg-red-1000 text-gray-300 font-bold mx-auto shadow-lg hover:bg-gray-800 hover:text-gray-500 my-4 mx-auto ">Create game</button>
			</form>
		</div>
	</div>

@endsection

