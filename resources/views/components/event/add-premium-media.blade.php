<section class="mt-10 w-full bg-white py-5 px-4 grid gap-6" x-data='{event_id: sessionStorage.getItem("event_id"), 
	spinner: false,
	createPromotionalVideoButtonText: "Add promotional video",
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
	submitForm(){
		$refs.AddPromotionalVideo.setAttribute("disabled", "")
		this.spinner = true
		this.createPromotionalVideoButtonText = "Uploading promotional video ..."
		this.toast("Uploading promotional video ...", "blue")
		
		let formdata = new FormData()
		formdata.append("video", $refs.video.files[0]);
		formdata.append("event_id", this.event_id);
		console.log(this.event_id)
		axios.post("/promoter/dashboard/events/promotional_video", formdata)
		.then( (response) => {
			$refs.AddPromotionalVideo.removeAttribute("disabled")
			this.spinner = true
			this.createPromotionalVideoButtonText = "Add promotional video"
			this.toast("Edit saved Succesfully", "green")
			
		})
		.catch( (error) => {
			this.spinner = false
			this.createPromotionalVideoButtonText = "Add promotional video"
			$refs.AddPromotionalVideo.removeAttribute("disabled")
			this.toast(error.response.data.message, "#DB162F")
			this.errorMessage = error.response.data.message
		})
	},
}'>
	<header>
        <h2 class="text-lg font-medium text-purple-1000 dark:text-gray-100">
            {{ __('Add Video promotional material and additional image to the event') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __(" Add a short promotional video to promote the event") }}
        </p>
    </header>
	<form action="" x-ref="form" @submit.prevent="submitForm" enctype="multipart/form-data">
		@csrf
		<div>
            <x-input-label for="video" :value="__('Promotional video')" />
            <input type="file" name="video" id="video" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full" x-ref="video">
            <x-input-error class="mt-2" :messages="$errors->get('video')" />
        </div>

        <div class="flex items-center gap-4 mt-6">
            <button type="submit"  x-ref="AddPromotionalVideo" class="w-full py-3 bg-red-1000 border-none text-gray-200 mt-4 hover:bg-red-900 duration-500" x-text="createPromotionalVideoButtonText"></button>
        </div>
	</form>
</section>