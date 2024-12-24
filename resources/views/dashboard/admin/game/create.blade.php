@extends('layouts.admin')

@section('title', 'Create fun games')

@section('content')
	<div class="text-black px-10" x-data='{ user: @json($user),
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
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
			<div class="max-w-lg">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Create awesome and fun games</h1>
				<p class="text-md leading-7 my-4">Create amazing games and ensure to provide adequate details to it. Also don't forget to add correct tags to it to ensure that it shows up in the right category</p>
				<a href="/admin/dashboard/games" class="px-5 py-3 font-bold md:font-normal bg-red-1000 text-gray-200">View games</a>
			</div>
			<img src="{{asset('/images/games.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="mt-10">
			<h1 class="text-center mt-6 mb-2 font-display tracking-wider text-2xl">Create an amazing game</h1>
			<form action="" 
						method="post"
						x-ref="form"
						@submit.prevent="submitForm()" 
						x-data='{ data: { name: "", summary: "", stepByStep: "", minimum_player: "", maximum_player: "", image: "", tags: "" }, 
						error: false,
						errorMessage: "",
						steps: [],
						submitForm(){
							this.toast("Creating games", "white", "blue")
							let formdata = new FormData($refs.form)
							{{-- formdata.append("image", $refs.image.files[0]); --}}
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
						}
					}'
						class="mx-auto md:w-10/12 border border-gray-100 shadow-md px-6 py-5 grid grid-cols-2 gap-x-6 gap-y-10 bg-gray-100 shadow-2xl">
				@csrf
				<div class="my-2">
					<label for="name" class="font-bold text-gray-950">Name of the game</label>
					<p class="text-gray-600 text-sm ">Hint: Should be easy to remember</p>
					<input type="text" name="name" id="name" required="required" minLength="5" x-model="data.name" class="focus:outline-0 focus:shadow-lg focus:border-none w-full">
				</div>

				<div class="my-2">
					<label for="summary" class="font-bold text-gray-950">Summary of the game</label>
					<p class="text-gray-600 text-sm ">Hint: Should be easy to remember</p>
					<textarea name="summary" id="summary" required="required" minLength="5" x-model="data.summary" class="focus:outline-0 focus:shadow-lg focus:border-none w-full min-h-56"></textarea>
				</div>

				<div class="my-2">
					<label for="stepByStep" class="font-bold text-gray-950">How-to play the game</label>
					<p class="text-gray-600 text-sm ">Hint: step by stepbon how to play to game</p>
					<textarea name="stepByStep" id="stepByStep" required="required" minLength="5" x-model="data.stepByStep" class="min-h-56 focus:outline-0 focus:shadow-lg focus:border-none w-full"></textarea>
					{{-- <button class="bg-gray-950 px-4 py-2 text-gray-300" @click="addStep()">Add step</button> --}}
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
					<label for="picture">Game image</label>
					<input type="file" name="picture" id="picture" required x-ref="picture">
				</div>
				
				<button type="submit" class="px-6 py-3 bg-red-1000 text-gray-300 font-bold mx-auto shadow-lg hover:bg-gray-800 hover:text-gray-500 my-4 mx-auto ">Create game</button>
			</form>
		</div>
	</div>

@endsection

