@extends('layouts.admin')

@section('title', "Plug request")

@section('content')
	<div class="text-purple-1000" x-data='{ plugs: @json($plugs),
        suspendedPlugs: @json($suspended),
        reason: "",
        plugIndex: 0,
        stats: @json($stats),
        user: @json($user),
        searchTerm: "",
        chosenPlug: null,
        hasSearched: false,
        init()
        {
            console.log(this.suspendedPlugs)
        },
        searchDatabaseForPlug()
        {
            if( this.searchTerm.length > 2 )
            {
                this.toast("Searching for plug", "blue")
                axios.post("/plugs/search", { searchTerm: this.searchTerm })
                .then( ( response ) => {
                    if(!response.data.error)
                    {
                        this.toast("Possible plugs returned successfully", "green")
                        hasSearched = true
                        this.plugs = response.data.data.data
                    }
                })
                .catch( (error) => {
                    this.toast("Error occured while searching for plug", "red")
                })
            }
            
        },
        backToHomePage()
        {
            axios.post("/plugs/backToHome")
            .then( ( response ) => {
                if(!response.data.error)
                {
                    hasSearched = false
                }
            })
            .catch( (error) => {
                this.toast("Error occured fetching plugs data", "red")
            })
        },

        showFullDetails(plug)
        {
            this.chosenPlug = plug
        },

        suspendPlug()
        {
            this.toast("Suspending plugs ...", "orange")
            axios.post("/admin/dashboard/plug/suspend", { plug_id: this.chosenPlug.id , reason: this.reason})
            .then( ( response ) => {
                if(!response.data.error)
                {
                    this.toast("Plug suspended successfully", "green")
                    plug.status = "Suspended"
                    this.plugs.splice(this.plugIndex, 1, this.chosenPlug)
                }
            })
            .catch( (error) => {
                this.toast("Error occured while suspending plug", "red")
            })
        },

        showReason(plug, index)
        {
            this.chosenPlug = plug
            this.plugIndex = index
            console.log(plug)
            $refs.modal.dispatchEvent(new Event("click"))
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

	}'>
		<section class="mt-2 grid gap-10 md:px-10 pb-12">
            <div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
                <div class="max-w-lg">
                    <h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
                    <p class="text-md leading-7 my-4">This is the page for managing plugs available on the CruiseHq platform</p> 
                </div>
                <img src="{{asset('/images/plug-request.svg')}}" alt="People chilling" class="w-96 h-52">
            </div>
            <div class="md:mt-10">
                <h2 class="font-bold font-display tracking-widest text-2xl">CruiseHq plugs statistics</h2>
            </div>
            
           <div class="grid grid-cols-4 gap-12">
                <div class="bg-purple-1000 px-3 py-5 text-gray-200 rounded-md shadow-md mt-2">
                    <h3 class="text-sm">Total plugs</h3>
                    <h1 class="text-5xl mt-2">{{$total_plugs}}</h1>
                </div>
                <template x-for="stat in stats">
                    <div>
                        <template x-if="stat.status == 'Active'">
                            <div class="bg-red-1000 px-3 py-5 text-gray-200 rounded-md shadow-md mt-2">
                                <h3 class="text-sm">Active</h3>
                                <h1 class="text-5xl mt-2" x-text="stat.total ?? '0'"></h1>
                            </div>
                        </template>
                        <template x-if="stat.status == 'Suspended'">
                            <div class="bg-yellow-400 px-3 py-5 text-purple-1000 rounded-md shadow-md mt-2">
                                <h3 class="text-sm">Suspended</h3>
                                <h1 class="text-5xl mt-2" x-text="stat.total ?? '0'"></h1>
                            </div>
                        </template>
                        <template x-if="stat.status == 'Inactive'">
                            <div class="bg-orange-400 px-3 py-5 text-purple-1000 rounded-md shadow-md mt-2">
                                <h3 class="text-sm">Inactive</h3>
                                <h1 class="text-5xl mt-2" x-text="stat.total ?? '0'"></h1>
                            </div>
                        </template>
                    </div>
                </template>
           </div>

            <div class="md:mt-10 mb-4">
                <h2 class="font-bold font-display tracking-widest text-2xl">CruiseHq plugs</h2>
            </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Plugs</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Suspended plugs</button>
                    </li>
                    <!-- <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-tab" data-tabs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Inactive</button>
                    </li> -->
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden px-4 py-12 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="/" method="post" class="flex justify-end gap-4" @submit.prevent="backToHomePage()">
                        <input type="search" name="" id="" x-model="searchTerm" @input.debounce.500ms="searchDatabaseForPlug" class="border-0 border-b-2 border-gray-950 outline-none focus:border-0 focus:outline-none focus:shadow-md shadow focus:ring-0 w-2/5" placeholder="search using plug parameters and not user parameters">
                        <button 
                            x-show="hasSearched" 
                            type="button" 
                            @click="backToHomePage()" 
                            class="border-0 underline underline-offset-4 border-purple-1000 ">
                            Back to Home
                        </button>
                    </form>

                    <template x-if="plugs.length > 0">
                        <div class="">
                            <div class="grid grid-cols-4 gap-10 gap-y-12 mt-4 py-10">
                                <template x-for="(plug, index) in plugs" :key="plug.id">
                                    <div class=" overflow-x-hidden" >
                                        <div class="hover:shadow-xl hover:border-gray-400 hover:duration-700 rounded-xl shadow-md p-4 bg-white border border-gray-300">
                                            <div class="flex justify-between items-center pb-4 ">
                                                <img :src="`{{ asset('/images') }}/${plug.flier}`" alt="" class="w-12 h-12 rounded-full bg-white">
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
                                            <div class="border-t border-gray-400 py-5 flex justify-between gap-4 items-center">
                                                <p x-text="plug.status" class="text-sm font-bold " :class="{
                                                    'text-green-500': plug.status == 'Active',
                                                    'text-gray-500': plug.status == 'Inactive',
                                                    'text-red-1000': plug.status == 'Suspended'
                                                }"></p>
                                                <template x-if="plug.status != 'Suspended'">
                                                    <button @click="showReason(plug, index)" class="px-3 py-2 rounded bg-red-1000 text-gray-200">Suspend</button>
                                                    
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="plugs.length < 1">
                        <p class="text-center py-3 text-purple-1000">No approved plugs yet</p>
                    </template>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 py-4" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <template x-if="suspendedPlugs.length > 0">
                        <div class="">
                            <div class="grid grid-cols-4 gap-10 gap-y-12 mt-4 py-10">
                                <template x-for="(plug, index) in suspendedPlugs" :key="plug.id">
                                    <div class=" overflow-x-hidden" >
                                        <div class="hover:shadow-xl hover:border-gray-400 hover:duration-700 rounded-xl shadow-md p-4 bg-white border border-gray-300">
                                            <div class="flex justify-between items-center pb-4 ">
                                                <img :src="`{{ asset('/images') }}/${plug.flier}`" alt="" class="w-12 h-12 rounded-full bg-white">
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
                                            <ul class="border-t border-gray-400 py-5 grid gap-8 items-center">
                                                <template x-for="reason in plug.user.suspensions">
                                                    <p x-text="reason.reason" class="text-sm "></p>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="plugs.length < 1">
                        <p class="text-center py-3 text-purple-1000">No suspended plugs</p>
                    </template>
                </div>
                <!-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div> -->
            </div>

		</section>
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
                                <img :src="`{{ asset('/images') }}/${chosenPlug.flier}`" alt="" class="w-full mx-auto bg-white">
                            </div>
                            <div class="pb-3 border-b border-gray-400 mt-2 text-center">   
                                <h3 class="text-sm tracking-wide " x-text="chosenPlug.user.nickname">Name of the plug</h3>
                                <p class="font-bold text-lg" x-text="chosenPlug.service">Service the chosenPlug offers</p>
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
        
        <!-- <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Toggle modal
        </button> -->
        <button class="" x-ref="modal" data-modal-target="popup-modal" data-modal-toggle="popup-modal"></button>
        <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Provide a reason / justification why the account is being suspended</h3>
                        <textarea x-model="reason" name="reason" id="reason" class="w-full h-96 my-3  p-3 rounded-md"></textarea>
                        <button data-modal-hide="popup-modal" @click="suspendPlug()" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Suspend plug
                        </button>
                        <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

