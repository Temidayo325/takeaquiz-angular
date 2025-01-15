@extends('layouts.tools')

@section("title", "CruiseHq Timer tool")

@section('content')
	<h2 class="text-xl md:text-3xl font-bold ">Stopwatch / Timer</h2>
	<div x-data="timer" class="flex flex-col items-center justify-center md:h-96 md:w-4/6 shadow-md border border-gray-200 md:mx-auto my-6 bg-white text-purple-1000">
    <!-- Timer Display -->
    <div class="text-center">
        <div 
            class="text-7xl md:text-9xl font-bold mb-4 py-10"
            :class="{'animate-pulse text-red-600': secondsRemaining <= 10 && secondsRemaining > 0}">
            <span x-text="formatTime(minutesRemaining)"></span>:<span x-text="formatTime(secondsRemaining % 60)"></span>
        </div>
    </div>

    <!-- Controls -->
    <div class="grid justify-start  md:grid-cols-4 gap-4 pb-7 ">
        <button 
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-nowrap w-full md:w-auto disabled:bg-gray-200 disabled:text-purple-1000" 
            :disabled="isRunning"
            @click="addMinute">
            Add Minute
        </button>
        <button 
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-nowrap w-full md:w-auto disabled:bg-gray-200 disabled:text-purple-1000" " 
            :disabled="isRunning"
            @click="subMinute">
            Subtract Minute
        </button>
        <button 
            class="px-4 py-2 bg-green-700 disabled:bg-gray-200 text-white rounded hover:bg-green-600 text-nowrap shadow-sm disabled:bg-gray-200 disabled:text-purple-1000" " 
            :disabled="isRunning"
            @click="startTimer" >
            Start
        </button>
        <button 
            class="px-4 py-2 bg-red-1000 text-white rounded hover:bg-gray-600 text-nowrap shadow-sm" 
            @click="resetTimer">
            Reset
        </button>
    </div>

    <!-- Hidden Audio for Alarm -->
    <audio x-ref="alarm">
        <source src="{{ asset('audio/alarm.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <script>
	    document.addEventListener('alpine:init', () => {
	        Alpine.data('timer', () => ({
	            minutesRemaining: 0,
                secondsRemaining: 0,
                isRunning: false,
                timer: null,
                formatTime(value) {
                    return String(value).padStart(2, '0');
                },
                addMinute() {
                    if (!this.isRunning) {
                        this.minutesRemaining += 1;
                        this.secondsRemaining += 60;
                    }
                },
                subMinute(){
                	if (!this.isRunning && this.minutesRemaining > 0) {
                        this.minutesRemaining -= 1;
                        this.secondsRemaining -= 60;
                    }
                },
                startTimer() {
                	if(this.minutesRemaining == 1)
                	{
                		this.minutesRemaining = 0
                		this.secondsRemaining = 59
                	}
                    if (this.secondsRemaining > 0 && !this.isRunning) {
                        this.isRunning = true;
                        this.timer = setInterval(() => {
                            if (this.secondsRemaining > 0) {
                                this.secondsRemaining -= 1;

                                if (this.secondsRemaining % 60 === 0) {
                                    this.minutesRemaining = Math.floor(this.secondsRemaining / 60);
                                }
                            }

                            if (this.secondsRemaining === 0) {
                                this.stopTimer();
                                this.$refs.alarm.play();
                            }
                        }, 1000);
                    }
                },
                stopTimer() {
                    this.isRunning = false;
                    clearInterval(this.timer);
                },

                resetTimer() {
                    this.stopTimer();
                    this.minutesRemaining = 0;
                    this.secondsRemaining = 0;
                }
	        }))
	    })
	</script>

</div>

@endsection