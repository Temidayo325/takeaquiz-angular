@extends('layouts.tools')

@section("title", "CruiseHq Coin flip")

@section("content")
<h2 class="text-xl md:text-3xl font-bold ">Coin flip</h2>
<div x-data="coinflip" class="flex flex-col items-center justify-center md:h-96 md:w-4/6 shadow-md border border-gray-200 md:mx-auto my-6 bg-white text-purple-1000 py-10">
    <!-- Coin Display -->
    <div class="relative w-32 h-32 mb-6">
        <div 
            class="absolute inset-0 bg-blue-500 text-white flex items-center justify-center rounded-full text-3xl font-bold shadow-xl transform transition-transform duration-700" 
            :class="flipClass" 
            x-text="result">
        </div>
    </div>

    <!-- Flip Button -->
    <button 
        class="px-6 py-3 bg-red-1000 text-white rounded hover:bg-red-700 shadow" 
        @click="flipCoin">
        Flip Coin
    </button>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('coinflip', () => ({
                result: '', // Holds the current result (Heads or Tails)
                flipClass: '', // Dynamic class for flip animation

                flipCoin() {
                    // Clear previous result
                    this.result = '';
                    
                    // Add the flipping animation class
                    this.flipClass = 'rotate-y-180';

                    // Randomly determine the result after animation
                    setTimeout(() => {
                        this.result = Math.random() < 0.5 ? 'Heads' : 'Tails';
                        this.flipClass = ''; // Reset animation class
                    }, 700); // Matches the animation duration
                }
            }))
        })
    </script>

</div>

</div>
@endsection
