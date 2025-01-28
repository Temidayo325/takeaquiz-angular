<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
   <link rel="manifest" href="/site.webmanifest">
   <link rel="manifest" href="/site.webmanifest">
	<title>@yield('title',"My Dashboard")</title>
	<!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
 
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

<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar" x-data='{user: @json($user),
   init(){
   {{-- console.log(this.user) --}}
}
   }'>
   <div class="h-full py-4 overflow-y-auto bg-white md:bg-gray-950 md:text-purple-200 text-purple-1000 dark:bg-gray-800 tracking-wider bg-sidebar bg-cover bg-no-repeat bg-blend-multiply">
      <div class="grid gap-2 px-5 md:px-5 my-1 tracking-wider md:mt-12"> 
            <img class="w-32 h-32 rounded-full border border-gray-400 mx-auto bg-white" :src="`{{ asset('./images') }}/${user.facecard}`" alt="My face-card">
            <div>
               <h2 x-text="user.nickname" class="text-2xl font-bold text-center"></h2>
               <p x-text="user.name" class="mt-2 text-center"></p>
            </div>
      </div>   
      <ul class="space-y-2 px-5 font-medium mt-7 md:mt-10 md:mb-3 text-purple-1000">
         <li>
            <a href="/user/dashboard" class="flex items-center w-full py-2 text-base text-purple-1000 md:text-purple-200 transition duration-75 px-3 md:px-5 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700">
               <svg class="w-5 h-5 text-purple-1000 md:text-purple-200 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         @if($user->hasAnyRole('promoter'))
            <li>
               <a href="/login" class="flex items-center w-full py-2 text-base text-purple-1000 md:text-purple-200 transition duration-75 px-3 md:px-5 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700">
                  <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 md:text-purple-200 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg>

                  <span class="flex-1 ms-3 whitespace-nowrap">Switch to Admin</span>
               </a>
            </li>
         @endif
         <li>
            <a href="/user/dashboard/profile" class="flex items-center w-full py-2 text-base text-purple-1000 transition duration-75 px-3 md:px-5 group md:hover:bg-gray-100 md:hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 md:text-purple-200">
               <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 md:text-purple-200 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>

               <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
            </a>
         </li>
         @if($user->hasAnyRole('plug'))
            <li>
               <a href="/user/dashboard/plug" class="flex justify-start w-full py-2 px-3 md:px-5 text-purple-1000 transition duration-75 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm md:text-purple-200">
                  <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white md:text-purple-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" /></svg>

                  <span class="flex-1 ms-3 whitespace-nowrap">Plug spot</span>
               </a>
            </li>
         @endif
         <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-purple-1000 transition duration-75 px-3 md:px-5 group md:hover:bg-gray-100 md:hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 md:text-purple-200" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                  <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white md:text-purple-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>

                  <span class="ml-3 flex-1 text-left rtl:text-right whitespace-nowrap">Manage my tickets</span>
                  <svg class="ml-1 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-2 md:pl-10">
                  <li>
                     <a href="/user/dashboard/tickets" class="flex items-center w-full p-2 text-purple-1000 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 md:text-purple-200">All ticket</a>
                  </li>
                  <li>
                     <a href="/user/dashboard/tickets/upcoming" class="flex items-center w-full p-2 text-purple-1000 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 md:text-purple-200">Upcoming tickets</a>
                  </li>
            </ul>
         </li>
         <li>
            <a href="/user/dashboard/events" class="flex justify-start w-full py-2 px-3 md:px-5 text-purple-1000 transition duration-75 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm md:text-purple-200">
               <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white md:text-purple-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>

               <span class="flex-1 ms-3 whitespace-nowrap">Cruise calender</span>
            </a>
         </li>
         <li>
            <a href="/user/dashboard/games" class="flex justify-start w-full py-2 px-3 md:px-5 text-purple-1000 transition duration-75 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm md:text-purple-200">
               <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white md:text-purple-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" /></svg>

               <span class="flex-1 ms-3 whitespace-nowrap">Cruise deck</span>
            </a>
         </li>
         <li>
            <a href="/logout" class="flex justify-start w-full py-2 px-3 md:px-5 text-purple-1000 transition duration-75 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm md:text-purple-200">
               <svg class="flex-shrink-0 w-5 h-5 text-purple-1000 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white md:text-purple-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
            </a>
         </li>
         
      </ul>
   </div>
</aside>

<div class="p-3 sm:ml-64 bg-gray-50 md:px-0 min-h-screen md:max-w-screen md:overflow-x-hidden">
   <div class="md:px-0 dark:border-gray-700">
      <header class="px-10 justify-between items-center hidden md:flex">
         <a class="font-body tracking-wider text-left text-md" href="/"><x-application-logo class="fill-current text-purple-1000 " /></a>
         <div class="flex justify-end gap-3 text-md font-bold">
            <a href="/user/dashboard/events" class="hover:underline underline-offset-4 hover:text-red-1000">Events</a>
            <a href="/user/dashboard/profile" class="hover:underline underline-offset-4 hover:text-red-1000">Profile</a>
            <a href="/logout" class="hover:underline underline-offset-4 hover:text-red-1000">Logout</a>
         </div>
      </header>
   		@yield("content")
   </div>
</div>
</body>
</html>