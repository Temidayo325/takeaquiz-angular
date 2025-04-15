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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #social-links ul
        {
            display: flex;
            gap: 15px;
        }
        div#social-links ul li a 
        {
            margin: 1px;
            font-size: 23px;
            color: #1d1128;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
	<main class="bg-gray-100 pb-0">
		<header class="py-3 px-4 sticky top-0 bg-white shadow-sm md:px-12 flex justify-between items-center z-70">
			<a href="/" class="flex justify-start items-center gap-2 py-2">
                <x-application-logo />
            </a>
            <ul class="flex justify-end gap-2 md:gap-10 text-purple-1000 font-bold">
                    @guest
                        <li><a href="/login" class="text-red-1000">Login</a></li>
                    @endguest
                    @auth
                        <li><a href="/login" class="text-purple-1000">Dashboard</a></li>
                    @endauth
                    <li class="md:hidden">          
                        <button type="button"><svg class="w-10 h-6 text-purple-1000" id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" /></svg>

                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                                <li><a href="/plugs" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Plugs</a></li>
                                <li><a href="/games" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cruise deck</a></li>
                                <li><a href="/tools" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tools</a></li>
                        </div>

                    </li>
                    <li class="hidden md:inline"><a href="/plugs" class="">Plugs</a></li>
                    <li class="hidden md:inline"><a href="/games">Cruise deck</a></li>
                    <li class="hidden md:inline"><a href="/tools">Tools</a></li>
                </ul>
		</header>
		<section x-data='{ plugs: [],
            searchTerm: "",
            hasSearched: false,
            chosenPlug: null,
            premuimPlugs: [],
            {{-- premuimPlugs: @json($premiumPlugs), --}}
            init()
            {
                <!-- <!-- this.premiumPlugs = this.plugs.data.filter( plug  => plug.isPremium == true) -->
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
                $refs.target.dispatchEvent(new Event("click"))
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
                        this.hasSearched = true
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
                        this.hasSearched = true
                    }
                })
            },
            showPlug(slug)
            {
                //window.location = "/plugs/"+slug
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
            <div class="my-5 md:my-10">
                <x-plugs.premium-plugs-carousel :plugs="$plugs"></x-plugs.premium-plugs-carousel>
            </div>
            <div>
                <h2 class="font-bold text-xl mb-3 mt-7">Plugs</h2>
                <button class="rounded-xl bg-yellow-200 text-sm text-purple-1000 py-1 px-4 hidden" title="View the full description of the Plug" x-ref="target" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" id="right-drawer-button" ></button>
                <form method="POST" class="flex justify-end md:items-center">
                    <input type="text" x-model="searchTerm" id="" placeholder="e.g. DJ" class="md:w-96 border border-gray-300 shadow-sm focus:outline-none focus:border-gray-300 focus:shadow-xl focus:border focus:ring-0" @input.debounce.500ms="searchDatabaseForPlug">
                </form>
                <template x-if="!hasSearched">
                    <div>
                        <h1>Search for desired plugs using the search bar above</h1>
                    </div>
                </template>
                <template x-if="hasSearched && plugs.data.length <= 0">
                    <p class="text-center leading-8 font-bold">We have not verified plugs that offers this service as of now, kindly check back at a later time</p>
                </template>
                <template x-if="hasSearched && plugs.data.length > 0">
                <div class="grid gap-6 md:grid-cols-4 md:py-10 py-6 grid-cols-1 md:mt-4">
                    <template x-for="plug in plugs.data">
                        <div class=" overflow-x-hidden" :key="plug.id" @click="showPlug(plug.slug)">
                            <div class="hover:shadow-xl hover:border-gray-400 hover:duration-700 rounded-xl shadow-md p-4 bg-white border border-gray-300">
                                <div class="flex justify-between items-center pb-4 ">
                                    <img :src="`{{ asset('/images') }}/${plug.logo}`" alt="" class="w-12 h-12 rounded-full bg-white">
                                    <button class="rounded-xl bg-yellow-200 text-sm text-purple-1000 py-1 px-4" title="View the full description of the Plug" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" id="right-drawer-button" @click="showFullDetails(plug)">View full profile</button>
                                </div>
                                <div class="pb-3 border-b border-gray-400">   
                                    <h3 class="font-bold text-lg tracking-wide" x-text="plug.user.nickname">Name of the plug</h3>
                                    <p x-text="plug.service">Service the plug offers</p>
                                    <p x-text="plug.state">Adamawa</p>
                                    <div class="overflow-x-auto mt-2 ">
                                        <h4 class="text-sm font-bold mb-2">Popular tags</h4>
                                        <div class="flex justify-start overflow-x-scroll gap-4 py-3 scroll-smooth custom-scrollbar">
                                            <template x-for="tag in plug.tags">
                                                <button @click="searchByTags(tag)" type="button" x-text="tag" class="px-6 py-2 bg-purple-1000 rounded-full text-gray-200 text-sm text-nowrap">Tags</button>
                                            </template>
                                        </div>
                                    </div>
                                </div>  
                                <div class="grid mt-2 overflow-x-hidden">
                                    <a :href="'tel:' + plug.user.phone"> 
                                        <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z"/></svg>
                                        <span x-text="plug.user.phone" class="text-sm"></span>
                                    </a>
                                    <a :href="'mailto:'+plug.user.email" class="flex justify-start gap-3 items-center"> 
                                        <svg class="w-5 h-8 inline text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg> <span x-text="plug.user.email" class="text-sm"></span>
                                    </a>
                                    <a :href="plug.social_media_links" rel="noopener noreferrer" target="__blank"> 
                                        <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z"/></svg>
                                    <span x-text="plug.social_media_links" class="text-sm text-wrap"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
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
            <div class="py-4 overflow-y-auto text-purple-1000 mt-3">
                <template x-if="chosenPlug != null ">
                    <div class="rounded-xl shadow-md p-4 bg-white border border-gray-300">
                            <div class="flex justify-center items-center pb-4 ">
                                <img :src="`{{ asset('/images') }}/${chosenPlug.logo}`" alt="" class="w-20 h-20 mx-auto rounded-full bg-white">
                            </div>
                            <div class="flex justify-center items-center pb-4 ">
                                <img :src="`{{ asset('/images') }}/${chosenPlug.flier}`" alt="" class="w-full h-auto mx-auto bg-white">
                            </div>
                            <div class="pb-3 border-b border-gray-400">   
                                <h3 class="font-bold text-lg tracking-wide text-center" x-text="chosenPlug.user.nickname">Name of the plug</h3>
                                <p x-text="chosenPlug.service">Service the chosenPlug offers</p>
                                <p x-text="chosenPlug.state">Adamawa</p>
                            </div>  
                            <div>
                                <h3 class="font-bold mt-3 pb-0 text-sm">Service</h3>
                                <p x-text="chosenPlug.service" class="text-gray-500"></p>

                                <h3 class="font-bold text-sm mt-3">Service summary</h3>
                                <p x-text="chosenPlug.service_summary" class="text-gray-500"></p>

                                <h3 class="font-bold mt-3 text-sm">Plug's Unique Selling Point</h3>
                                <p x-text="chosenPlug.usp" class="text-gray-500"></p>

                            </div>
                            <div class="grid mt-2 border-t border-gray-400">
                                <h3 class="font-bold mt-3 text-sm">Service Availability</h3>
                                <p x-text="chosenPlug.location_based" class="text-gray-500"></p>

                                <h3 class="font-bold mt-3 text-sm">State</h3>
                                <p x-text="chosenPlug.state" class="text-gray-500"></p>

                                <h3 class="font-bold mt-3 text-sm">Contact Address (If location-based)</h3>
                                <p x-text="chosenPlug.physical_address" class="text-gray-500"></p>

                                <h3 class="font-bold mt-3 text-sm">Available for travel ?</h3>
                                <p x-text="( chosenPlug.travel == 1) ? 'Yes' : 'No'" class="text-gray-500"></p>
                            </div>
                            <div class="grid mt-2 border-t border-gray-400">
                                <h3 class="font-bold mt-3 text-sm">Email</h3>
                                <a :href="'mailto:' + chosenPlug.user.email" class="text-gray-500 block" x-text="( chosenPlug.contact_email == null ) ? chosenPlug.user.email :  chosenPlug.contact_email"></a>

                                <h3 class="font-bold mt-3 text-sm">Website / Portfolio</h3>
                                <a :href="( chosenPlug.contact_portfolio == null ) ? chosenPlug.user.phone :  chosenPlug.contact_portfolio" class="text-gray-500" x-text="( chosenPlug.contact_portfolio == null ) ? chosenPlug.user.phone :  chosenPlug.contact_portfolio" ></a>

                                <h3 class="font-bold mt-3 text-sm">Phone / WhatsApp</h3>
                                <a :href="'tel:' + ( chosenPlug.contact_whatsapp == null ) ? chosenPlug.user.phone :  chosenPlug.contact_whatsapp" class="text-gray-500" x-text="( chosenPlug.contact_whatsapp == null ) ? chosenPlug.user.phone :  chosenPlug.contact_whatsapp"></a>

                                <h3 class="font-bold mt-3 text-sm">Social Media Links</h3>
                                <a :href="chosenPlug.social_media_links" target="__blank" class="text-gray-500" x-text="chosenPlug.social_media_links"></a>
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