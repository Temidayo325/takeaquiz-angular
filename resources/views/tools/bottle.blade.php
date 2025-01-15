@extends('layouts.tools')

@section("title", "CruiseHq Spin the bottle tool")

@section('content')
	<h2 class="text-xl md:text-3xl font-bold ">Spin the bottle</h2>
	<div x-data="bottle" class="flex flex-col items-center justify-center md:h-96 md:w-4/6 shadow-md border border-gray-200 md:mx-auto my-6 bg-white text-purple-1000 py-10">
    <!-- Bottle and Spinner -->
    <div class="relative">
        <!-- Bottle Image -->
        <div 
            class="w-32 h-64 bg-center bg-cover rounded-full "
            x-ref="bottle"
            style="background-image: url('{{ asset('images/tools/bottle.png') }}');"
            :style="{ transform: `rotate(${rotation}deg) ` }"
            class="transition-transform duration-[3000ms] ease-out"
        >
        </div>
    </div>

    <!-- Number of Participants -->
    <div class="mt-6">
        <label class="block text-gray-700 font-semibold mb-2" for="participants">Participants</label>
        <input 
            type="number" 
            id="participants" 
            x-model="participants" 
            class="w-20 px-2 py-1 border rounded focus:outline-none focus:ring"
            min="2" 
            placeholder="minimum should be 2">
    </div>

    <!-- Spin Button -->
    <button 
        class="mt-4 px-6 py-3 bg-green-500 text-white rounded hover:bg-green-600 shadow" 
        @click="spinBottle">
        Spin the Bottle
    </button>

    <!-- Selected Participant -->
    <div class="mt-4 text-lg font-semibold" x-show="selectedParticipant !== null">
        <span x-text="`Participant ${selectedParticipant + 1} is selected!`"></span>
    </div>
</div>

    <script>
	    document.addEventListener('alpine:init', () => {
	        Alpine.data('bottle', () => ({
	            participants: 2, // Default number of participants
                rotation: 0, // Current rotation angle of the bottle
                selectedParticipant: null, // The selected participant index

                spinBottle() {
                    this.$refs.bottle.classList.toggle("animate-spin")
                    if (this.participants < 2) {
                        alert('Please enter at least 2 participants!');
                        return;
                    }

                    // Determine the rotation (360 degrees divided by participants)
                    const anglePerParticipant = 360 / this.participants;

                    // Calculate the target rotation
                    const extraSpins = 3; // Additional full spins for flair
                    const targetRotation = (extraSpins * 360) + (this.selectedParticipant * anglePerParticipant);
                   setTimeout(() => {
                        this.$refs.bottle.classList.toggle("animate-spin")
                          // Randomly select a participant
                        this.selectedParticipant = Math.floor(Math.random() * this.participants);

                   }, 3000)
                    // Apply the rotation
                   this.rotation = targetRotation;
                }
	        }))
	    })
	</script>

</div>

@endsection