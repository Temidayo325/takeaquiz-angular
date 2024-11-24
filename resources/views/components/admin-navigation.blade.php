<ul class="space-y-2 font-medium md:pb-12">
   <li>
      <a class="text-center w-full p-2 text-gray-950 block bg-gray-200  dark:text-white dark:hover:bg-gray-700 text-sm" href="#">Admin Controls</a>
   </li>
   <li>
      <a href="/admin/dashboard" class="flex items-center w-full py-2 text-base text-gray-100 transition duration-75 px-3 md:px-6 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700">
         <svg class="w-5 h-5 text-gray-200 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
         </svg>
         <span class="ms-3">Admin Dashboard</span>
      </a>
   </li>
   <li>
      <button type="button" class="flex items-center w-full py-2 text-base text-gray-200 transition duration-75 px-3 md:px-5 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="toggle-admin-user-ul">
         <svg class="flex-shrink-0 w-6 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">User management</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
      </button>
      <ul id="toggle-admin-user-ul" class="hidden py-2 space-y-2">
            <li>
               <a href="{{ route('admin.user.index') }}" class="flex items-center w-full p-2 text-gray-200 transition duration-75 pl-11 md:pl-16 md:ml-3 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm" class="">All users</a>
            </li>
      </ul>
   </li>
   <li>
      <button type="button" class="flex items-center w-full py-2 text-base text-gray-200 transition duration-75 px-3 md:px-5 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="toggle-admin-ticket-ul">
         <svg class="flex-shrink-0 w-6 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Event management</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
      </button>
      <ul id="toggle-admin-ticket-ul" class="hidden py-2 space-y-2">
            <li>
               <a href="{{ route('admin.event.index') }}" class="flex items-center w-full p-2 text-gray-200 transition duration-75 pl-11 md:pl-16 md:ml-3 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700 text-sm" class="{{ Request::routeIs('admin.event.index') ? 'bg-gray-100 text-gray-950' : '' }}">All events</a>
            </li>
      </ul>
   </li>
   <li>
      <button type="button" class="flex items-center w-full p-2 text-base text-gray-200 transition duration-75 px-3 md:px-5 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="toggle-admin-event-ul">
            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>

            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Manage tickets</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
      </button>
      <ul id="toggle-admin-event-ul" class="hidden py-2 space-y-2">
            <li>
               <a href="/admin/dashboard/tickets" class="flex items-center w-full p-2 text-gray-200 transition duration-75 rounded-lg pl-20 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700">All tickets</a>
            </li>
            <li>
               <a href="#" class="flex items-center w-full p-2 text-gray-200 transition duration-75 rounded-lg pl-20 group hover:bg-gray-100 hover:text-gray-950 dark:text-white dark:hover:bg-gray-700">Ticket sales</a>
            </li>
      </ul>
   </li>
</ul>