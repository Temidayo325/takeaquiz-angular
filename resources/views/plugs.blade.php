<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
	<title>Cruise Plugs | Cruise certified plugs for your next events</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" defer src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>
	<main class="bg-gray-100 pb-0">
		<header class="py-3 px-4 shadow-sm sticky top-0 bg-white shadow-sm md:px-12 flex justify-between items-center">
			<a href="/" class="flex justify-start items-center gap-2 py-2">
                <x-application-logo />
            </a>
            <ul class="flex justify-end gap-2 text-purple-1000 font-bold">
                <li><a href="/login" class="text-red-1000 px-3">Login</a></li>
            	<li><a href="/games">Cruise Deck</a></li>
            </ul>
		</header>
		<section x-data='{ plugs: @json($plugs),
            searchTerm: "",
            chosenPlug: null,
            premuimPlugs: [],
            {{-- premuimPlugs: @json($premiumPlugs), --}}
            init()
            {
                this.premiumPlugs = this.plugs.data.filter( plug  => plug.isPremium == true)
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
            showFullDetails(plug)
            {
                this.chosenPlug = plug
            },
            searchDatabaseForPlug()
            {
                this.toast("Searching for user", "blue")
                axios.post("/plugs/search", { searchTerm: this.searchTerm })
                .then( ( response ) => {
                    if(!response.data.error)
                    {
                        this.toast("Possible plugs returned successfully", "green")
                        this.plugs = response.data.data
                    }
                })
                .catch( (error) => {
                    this.toast("Error occured while searching for user", "red")
                })
            },
            searchByTags(tag)
            {
                this.toast("Searching for user", "blue")
                axios.post("/plugs/search/tags", { searchTerm: tag })
                .then( ( response ) => {
                    if(!response.error)
                    {
                        this.toast("Possible plugs returned successfully", "green")
                        this.plugs = response.plugs.data
                    }
                })
            },
            fetchData(cursor)
            {
                if(typeof cursor == null)
                {
                    return false;
                }
                try {
                    this.toast("fetching plugs", "blue")
                    axios.post("/plugs/search/paginate", {cursor: cursor})
                    .then(response => {
                        this.toast("Plugs returned successfully", "green")
                        this.plugs = response.data
                    })
                    .catch( (error) => {
                        this.toast("Error occured while trying to fetch data", "red")
                    })
                } catch (error) {
                    this.toast("Error occured while trying to fetch data", "red")
                }
            },
        }' class="md:px-10 px-4 py-6 md:py-4">
            <div>
                <h2 class="font-bold text-xl mb-3">Plugs</h2>
                <template x-if="plugs.data.length > 0">
                    <x-plugs.premium-plugs-carousel :plugs="$plugs"></x-plugs.premium-plugs-carousel>
                </template>
                <form method="POST" class="flex justify-end md:items-center" x-show="plugs.data.length > 4">
                    <input type="text" x-model="searchTerm" id="" placeholder="e.g. DJ" class="md:w-96 border border-gray-300 shadow-sm focus:outline-none focus:border focus:border-gray-300 focus:shadow-xl focus:border focus:border-gray-200 focus:ring-0" @input.debounce.500ms="searchDatabaseForPlug">
                </form>
                <template x-if="plugs.data.length <= 0">
                    <p class="text-center leading-8 font-bold">We have not verified any plugs as of now, kindly check back at a later time</p>
                </template>
                <template x-for="plug in plugs.data">
                    <div class="grid gap-6 md:grid-cols-4 md:py-10 py-6 grid-cols-1 overflow-x-hidden" :key="plug.id">
                        <div class="hover:shadow-xl hover:border-gray-400 hover:duration-700 rounded-xl shadow-md p-4 bg-white border border-gray-300">
                            <div class="flex justify-between items-center pb-4 ">
                                <img :src="`{{ asset('/images') }}/${plug.flier}`" alt="" class="w-12 h-12 rounded-full bg-white">
                                <button class="rounded-xl bg-yellow-200 text-sm text-purple-1000 py-1 px-4" title="View the full description of the Plug" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" id="right-drawer-button" @click="showFullDetails(plug)">View full profile</button>
                            </div>
                            <div class="pb-3 border-b border-gray-400">   
                                <h3 class="font-bold text-lg tracking-wide" x-text="plug.user.nickname">Name of the plug</h3>
                                <p x-text="plug.service">Service the plug offers</p>
                                <p x-text="plug.state">Adamawa</p>
                                <div class="overflow-x-auto mt-2">
                                    <h4 class="text-sm font-bold mb-2">Popular tags</h4>
                                    <div class="flex justify-start overflow-x-scroll gap-4 py-3 scroll-smooth ">
                                        <template x-for="tag in plug.tags">
                                            <button @click="searchByTags(tag)" type="button" x-text="tag" class="px-6 py-2 bg-purple-1000 rounded-full text-gray-200 text-sm text-nowrap">Tags</button>
                                        </template>
                                    </div>
                                </div>
                            </div>  
                            <div class="grid mt-2">
                                <a :href="'tel:' + plug.user.phone"> 
                                    <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" /></svg>
                                    <span x-text="plug.user.phone"></span>
                                </a>
                                <a :href="'mailto:'+plug.user.email"> 
                                    <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" /></svg> <span x-text="plug.user.email"></span>
                                </a>
                                <a :href="plug.social_media_links" target="__blank"> <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                                <span x-text="plug.social_media_links"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
                {{-- Pagination link --}}
                <div class="flex justify-end gap-10 my-10">
                    <template x-if="plugs.prev_cursor != null">
                        <button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(plugs.prev_cursor)">Prev</button>
                    </template>
                    <template x-if="plugs.next_cursor != null">
                        <button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(plugs.next_cursor)">Next</button>
                    </template>
                </div>
            </div>

            <!-- Side bar Canvas -->
            <div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
            <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close menu</span>
            </button>
            <div class="py-4 overflow-y-auto text-black">
                <template x-if="chosenPlug != null ">
                    <div class="rounded-xl shadow-md p-4 bg-white border border-gray-300">
                            <div class="flex justify-center items-center pb-4 ">
                                <img :src="`{{ asset('/images') }}/${chosenPlug.flier}`" alt="" class="w-20 h-20 mx-auto rounded-full bg-white">
                            </div>
                            <div class="pb-3 border-b border-gray-400">   
                                <h3 class="font-bold text-lg tracking-wide text-center" x-text="chosenPlug.user.nickname">Name of the plug</h3>
                                <p x-text="chosenPlug.service">Service the chosenPlug offers</p>
                                <p x-text="chosenPlug.state">Adamawa</p>
                            </div>  
                            <div>
                                <h3 class="font-bold pb-2 mt-3">Address</h3>
                                <p x-text="chosenPlug.address"></p>

                                <h3 class="font-bold text-sm pb-2">Service summary</h3>
                                <p x-text="chosenPlug.service_summary"></p>

                                <h3 class="font-bold mt-3 pb-2">Plug's Unique Selling Point</h3>
                                <p x-text="chosenPlug.usp"></p>

                                <h3 class="font-bold mt-3 pb-2">Does the plug engage in out-of-state delivery ?</h3>
                                <p x-text="( chosenPlug.travel == 1) ? 'Yes' : 'No'"></p>
                            </div>
                            <div class="grid mt-2">
                                <h3 class="font-bold mt-3 pb-2">Contact details</h3>
                                <a :href="'tel:' + chosenPlug.user.phone"> 
                                    <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" /></svg>
                                    <span x-text="chosenPlug.user.phone"></span>
                                </a>
                                <a :href="'mailto:'+chosenPlug.user.email"> 
                                    <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" /></svg> <span x-text="chosenPlug.user.email"></span>
                                </a>
                                <a :href="chosenPlug.social_media_links" target="__blank"> <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                                <span x-text="chosenPlug.social_media_links"></span>
                                </a>
                            </div>
                        </div>
                </template>
            </div>
        </div>
        </section>
	</main>
	<x-footer></x-footer>
</body>
</html>