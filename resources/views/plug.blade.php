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
    <!-- <script src="https://kit.fontawesome.com/50172bf2e8.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>
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
		<header class="py-3 px-4 shadow-sm sticky top-0 bg-white md:px-12 flex justify-between items-center">
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
		<section class="md:px-10 px-4 py-6 md:py-4">
            <div>
                <div class="rounded-xl shadow-md p-4 bg-white border border-gray-300 md:w-96 md:mx-auto">
                    <div class="flex justify-center items-center pb-4 ">
                        <img src="{{ asset('/images/'. $plug->flier) }}" alt="" class="w-full h-24 md:h-44 rounded-tr-xl rounded-tl-xl mx-auto bg-white">
                    </div>
                    <div class="pb-3 border-b border-gray-400 text-center">   
                        <h3 class="font-bold text-lg tracking-wide text-center">{{ $plug->user->nickname}}</h3>
                        <p >{{ $plug->user->name }}</p>
                        <p> {{ $plug->state }} </p>
                    </div>  
                    <div class="grid mt-2 pb-4">
                        <h3 class="font-bold mt-3 pb-2">Contact details</h3>
                        <a href="tel: {{ $plug->user->phone }} "> 
                            <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" /></svg>
                            <span> {{ $plug->user->phone }}  </span>
                        </a>
                        <a href="mailto:{{ $plug->user->email }}"> 
                            <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" /></svg> <span >{{ $plug->user->email }}</span>
                        </a>
                        <a href="{{ $plug->social_media_links }}" target="__blank"> <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                        <span>{{ $plug->social_media_links }}</span>
                        </a>
                    </div>
                    <div>
                        <h3 class="font-bold mt-3 pb-0 text-sm">Service</h3>
                        <p class="text-gray-500"> {{ $plug->service}} </p>

                        <h3 class="font-bold text-sm mt-3">Service summary</h3>
                        <p class="text-gray-500"> {{ $plug->service_summary}} </p>

                        <h3 class="font-bold mt-3 text-sm">Plug's Unique Selling Point</h3>
                        <p class="text-gray-500">{{ $plug->usp}}</p>

                    </div>
                    <div class="grid mt-2 border-t border-gray-400">
                        <h3 class="font-bold mt-3 text-sm">Service Availability</h3>
                        <p class="text-gray-500">{{ $plug->location_based }}</p>

                        <h3 class="font-bold mt-3 text-sm">State</h3>
                        <p class="text-gray-500">{{ $plug->state }}</p>

                        <h3 class="font-bold mt-3 text-sm">Contact Address (If location-based)</h3>
                        <p class="text-gray-500">{{ $plug->physical_address }}</p>

                        <h3 class="font-bold mt-3 text-sm">Available for travel ?</h3>
                        <p class="text-gray-500">{{ ( $plug->travel == 1) ? "Yes" : "No"  }}</p>
                    </div>
                    <div class="grid mt-2 border-t border-gray-400">
                        <h3 class="font-bold mt-3 text-sm">Email</h3>
                        <a :href="mailto:" class="text-gray-500 block" >{{ ( $plug->contact_email == null) ? $plug->user->email : $plug->contact_email}}</a>

                        <h3 class="font-bold mt-3 text-sm">Website / Portfolio</h3>
                        <a :href="{{ ( $plug->contact_portfolio == null) ? $plug->social_media_links : $plug->contact_portfolio}}" class="text-gray-500">{{ ( $plug->contact_portfolio == null) ? $plug->social_media_links : $plug->contact_portfolio}}</a>

                        <h3 class="font-bold mt-3 text-sm">Phone / WhatsApp</h3>
                        <a :href="'tel:' + ( chosenPlug.contact_whatsapp == null ) ? chosenPlug.user.phone :  chosenPlug.contact_whatsapp" class="text-gray-500">{{ ( $plug->contact_whatsapp == null) ? $plug->user->phone : $plug->contact_whatsapp}}</a>

                        <h3 class="font-bold mt-3 text-sm">Social Media Links</h3>
                        <a :href="chosenPlug.social_media_links" target="__blank" class="text-gray-500" x-text="chosenPlug.social_media_links"></a>
                    </div>
                </div>
            </div>
        </section>
	</main>
	<x-footer></x-footer>
</body>
</html>