@extends('layouts.admin')

@section('title', 'Create fun games')

@section('content')
	<div class="text-black px-10" x-data='{ user: @json($user),
		init() {
        	sessionStorage.setItem("user", JSON.stringify(this.user))
   		}
	}'>
		<h1>Create Awesome games</h1>
		<div>
			<form action="" 
						method="post"
						x-ref="form"
						@submit.prevent="submitForm()" 
						x-data='{ data: { name: "", summary: "", stepByStep: "", minimum_player: "", maximum_player: "", image: "", tags: "" }, 
						error: false,
						errorMessage: "",
						steps: [],
						submitForm(){
							let formdata = new FormData($refs.form)
							formdata.append("image", $refs.image.files[0]);
							axios.post("/admin/dashboard/games/create", formdata)
							.then( ( response ) => {
								console.log(response)
								this.data = { name: "", summary: "", stepByStep: "", minimum_player: "", maximum_player: "", image: "", tags: "" }
								this.error = false
								this.steps = []
							})
							.catch(error => console.log(error))
						},
						addStep()
						{
							this.steps.push(this.data.stepByStep)
						}
					}'
						class="mx-auto md:w-6/12 border border-gray-400 shadow-md px-20 py-5 grid gap-3">
				@csrf
				<div class="my-2">
					<label for="name" class="font-bold text-gray-950">Name of the game</label>
					<p class="text-gray-600 text-sm ">Hint: Should be easy to remember</p>
					<input type="text" name="name" id="name" required="required" minLength="5" x-model="data.name" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>

				<div class="my-2">
					<label for="summary" class="font-bold text-gray-950">Summary of the game</label>
					<p class="text-gray-600 text-sm ">Hint: Should be easy to remember</p>
					<textarea name="summary" id="summary" required="required" minLength="5" x-model="data.summary" class="focus:outline-0 focus:shadow-lg focus:border-none w-full"></textarea>
				</div>
				<div class="my-2">
					<label for="stepByStep" class="font-bold text-gray-950">How-to play the game</label>
					<p class="text-gray-600 text-sm ">Hint: step by stepbon how to play to game</p>
					<textarea name="stepByStep" id="stepByStep" required="required" minLength="5" x-model="data.stepByStep" class="focus:outline-0 focus:shadow-lg focus:border-none w-full"></textarea>
					<button class="bg-gray-950 px-4 py-2 text-gray-300" @click="addStep()">Add step</button>
				</div>
				<div class="my-2">
					<label for="tags" class="font-bold text-gray-950">Game tags</label>
					<p class="text-gray-600 text-sm ">Hint: Hashtags for the game</p>
					<input type="text" name="tags" id="tags" required="required" minLength="5" x-model="data.tags" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>
				<div class="">
					<label for="minimum_player">Minimum number of players</label>
					<input type="tel" name="minimum_player" id="minimum_player" required x-model="data.minimum_player">
				</div>
				<div class="">
					<label for="maximum_player">Maximum number of players</label>
					<input type="tel" name="maximum_player" id="maximum_player" required x-model="data.maximum_player">
				</div>		
				<div class="">
					<label for="image">Game image</label>
					<input type="file" name="image" id="image" required x-ref="image">
				</div>
				
				<button type="submit" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold mx-auto shadow-lg hover:bg-gray-800 hover:text-gray-500 my-4 mx-auto ">Create game</button>
			</form>
		</div>
	</div>

@endsection

