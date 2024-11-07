<aside  
		x-data='{ toggle(){ $dispatch("notify") } }' 
		class="fixed top-0 right-0 z-40 w-screen h-screen bg-white/50 flex justify-end transition-transform -translate-x-full sm:translate-x-0"
>
	<div class="h-full flex-grow cursor-pointer" @click="toggle"></div>
	<div class="w-10/12 md:w-4/12 px-3 text-gray-400 h-full bg-gray-950 overflow-x-auto">
		{{ $slot }}
	</div>
</aside>