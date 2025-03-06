<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
   <link rel="manifest" href="/site.webmanifest">
	<title>@yield('title',"My Dashboard")</title>
	<!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
	

<header class="shadow-lg text-purple-1000 border-b sticky top-0 bg-white border-gray-300 flex justify-start gap-20 items-center py-2 z-40 md:hidden">
   <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
      <span class="sr-only">Open sidebar</span>
      <svg class="w-6 h-6 text-purple-1000" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path></svg>
   </button>
   <a href="/" class="font-display tracking-wider text-left text-xl">{{config('app.name')}}</a>
</header>

<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-50 w-64 md:w-72 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full py-6 overflow-y-auto bg-gray-950 text-purple-200 dark:bg-gray-800 tracking-wider bg-admin-sidebar bg-cover bg-no-repeat bg-blend-darken" x-data='{user: @json($user),
   init()
   {
      sessionStorage.setItem("user", JSON.stringify(this.user))
   }
   }'>
      <div class="flex justify-start text-purple-200 items-center gap-2 px-3 md:px-5 my-3 tracking-wide md:mt-4 font-body"> 
         <div class="grid gap-2 px-5 md:px-5 my-1 tracking-wider"> 
            <img class="w-32 h-32 rounded-full border border-gray-400 mx-auto bg-white" :src="`{{ asset('./images') }}/${user.facecard}`" alt="My face-card">
            <div>
               <h2 x-text="user.nickname" class="text-md font-bold text-center"></h2>
               <p x-text="user.name" class="mt-2 text-sm text-center"></p>
            </div>
         </div> 
      </div>  
      <ul class="space-y-2 mt-10 md:mb-3 text-purple-200 font-bold">
         <li>
            <a href="/promoter/dashboard" class="flex items-center w-full py-2 text-base transition duration-75 px-3 md:px-5 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700">
               <svg class="w-4 h-4 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="/promoter/dashboard/profile" class="flex items-center w-full py-2 text-base transition duration-75 px-3 md:px-5 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700">
               <svg class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>

               <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
            </a>
         </li>
         <li>
            <a href="/plugs" class="flex justify-start w-full py-2 px-3 md:px-5 text-purple-1000 transition duration-75 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm md:text-purple-200">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white md:text-purple-200"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>

               <span class="flex-1 ms-3 whitespace-nowrap">Plug spot</span>
            </a>
         </li>
         @if($user->hasAnyRole('plug'))
            <li>
               <a href="/user/dashboard/plug" class="flex items-center w-full py-2 text-base transition duration-75 px-3 md:px-5 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700">
               <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white md:text-purple-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>

                  <span class="flex-1 ms-3 whitespace-nowrap">Create Plug account</span>
               </a>
            </li>
         @endif
         <li>
            <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 px-3 md:px-5 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                  <svg class="flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>

                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Ticket management</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-2 md:pl-10 ml-10 md:ml-0">
                  <li>
                     <a href="/promoter/dashboard/tickets" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700">Ticket performance</a>
                  </li>
                  <li>
                     <a href="/promoter/dashboard/tickets/create" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700">Create ticket</a>
                  </li>
                {{--   <li>
                     <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Ticket sales</a>
                  </li> --}}
            </ul>
         </li>
         <li>
            <button type="button" class="flex items-center w-full py-2 text-base transition duration-75 px-3 md:px-5 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="event-toggle">
               <svg class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Event management</span>
                  <svg class="flex-shrink-0 w-3 h-3 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="event-toggle" class="hidden py-2 space-y-2 ml-10">
                  <li>
                     <a href="{{ route('promoter.event.index') }}" class="flex items-center w-full p-2  transition duration-75 pl-11 md:pl-12 md:ml-3 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700 text-sm" class="{{ Request::routeIs('promoter.event.index') ? 'bg-gray-100 text-gray-950' : '' }}">All events</a>
                  </li>
                  <li>
                     <a href="{{ route('promoter.event.create') }}" class="flex items-center w-full p-2  transition duration-75 pl-11 md:pl-12 md:ml-3 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700 text-sm">Create event</a>
                  </li>
            </ul>
         </li>
         <li>
            <a href="/user/dashboard" class="flex justify-start w-full py-2 px-3 md:px-5 transition duration-75 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700 text-sm">
               <svg class="flex-shrink-0 w-5 h-5 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>

               <span class="flex-1 ms-3 whitespace-nowrap">Switch to user</span>
            </a>
         </li>
         <li>
            <a href="/logout" class="flex justify-start w-full py-2 px-3 md:px-5 transition duration-75 group hover:bg-purple-200 hover:text-purple-1000 dark:text-white dark:hover:bg-gray-700 text-sm">
               <svg class="flex-shrink-0 w-4 h-5 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
            </a>
         </li>
      </ul>
      @if($user->hasAnyRole('admin'))
         <x-admin-navigation></x-admin-navigation>
      @endif
   </div>
</aside>

<div class="sm:ml-64">
   <div class="dark:border-gray-700 bg-gray-100 md:bg-purple-100 md:px-10">
      <header class="px-10 py-6 justify-between items-center hidden md:flex text-purple-1000 ">
         <a href="/" class="font-body tracking-wider text-left font-bold text-md"><x-application-logo /></a>
         <div class="flex justify-end gap-3 text-md">
            <a href="/promoter/dashboard/events" class="hover:underline underline-offset-4 hover:text-red-1000">My Events</a>
            <a href="/promoter/dashboard/profile" class="hover:underline underline-offset-4 hover:text-red-1000">My Profile</a>
            <a href="/logout" class="hover:underline underline-offset-4 hover:text-red-1000">Logout</a>
         </div>
      </header>
   	<div class="min-h-screen">
         @yield("content")
      </div>
   </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
</html>