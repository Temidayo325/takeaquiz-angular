@extends('layouts.tools')

@section("title", "CruiseHq Spin the bottle tool")

@section('content')
	<h2 class="text-xl md:text-3xl font-bold ">Spin the bottle</h2>
	<div x-data="bottle" class="flex flex-col items-center justify-center md:h-3/4 md:w-4/6 shadow-md border border-gray-200 md:mx-auto my-6 bg-white text-purple-1000 py-10">
    <!-- Bottle and Spinner -->
    <div class="relative">
        <!-- Participant Wheel -->
        <div class="relative w-64 h-64 md:w-96 md:h-96 rounded-full border border-gray-600">
            <template x-for="(participant, index) in Array.from({ length: participants })" :key="index">
                <div 
                    class="absolute w-full h-full flex justify-center items-center"
                    :style="{
                        transform: `rotate(${(360 / participants) * index}deg)`,
                        clipPath: `polygon(50% 50%, 0 0, 100% 0)`,
                    }"
                >
                    <div 
                        class="absolute w-full h-full bg-purple-500 text-center text-white font-bold"
                        :style="{
                            transform: `rotate(${360 / participants / 2}deg)`,
                            clipPath: `polygon(50% 50%, 100% 0, 0 0)`,
                            border: '1px solid gray',
                        }"
                    >
                        <span x-text="`Participant ${index + 1}`"></span>
                    </div>
                </div>
            </template>

            <!-- Bottle Image -->
            <div 
                class="absolute left-14 top-6 w-32 h-48 md:h-64 bg-center bg-cover rounded-full"
                x-ref="bottle"
                style="background-image: url('{{ asset('images/tools/bottle.png') }}');"
                :style="{ transform: `rotate(${rotation}deg)` }"
                class="transition-transform duration-[3000ms] ease-out"
            >
            </div>
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
            participants: 4, // Default number of participants
            rotation: 0, // Current rotation angle of the bottle
            selectedParticipant: null, // The selected participant index

            spinBottle() {
                if (this.participants < 2) {
                    alert('Please enter at least 2 participants!');
                    return;
                }

                // Determine the rotation (360 degrees divided by participants)
                const anglePerParticipant = 360 / this.participants;

                // Randomly select a participant
                this.selectedParticipant = Math.floor(Math.random() * this.participants);

                // Calculate the target rotation
                const extraSpins = 3; // Additional full spins for flair
                const targetRotation = (extraSpins * 360) + (this.selectedParticipant * anglePerParticipant);

                // Apply the rotation
                this.rotation = targetRotation;
            }
        }))
    })
</script>


</div>

@endsection