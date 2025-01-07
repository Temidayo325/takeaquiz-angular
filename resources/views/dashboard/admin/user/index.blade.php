
@extends('layouts.admin')

@section('title', 'Users dashboard')

@section('content')
	<div class="text-purple-1000 px-10 pb-20" x-data='{ user: @json($user),
		users: @json($users),
		originalRoles: @json($roles),
		rolesToAssign: [],
		searchTerm: "",
		safeKeepUsersList: [],
		chosenUser: null,
		searchResult: [],
		init() {
			{{-- console.log(this.users) --}}
        	sessionStorage.setItem("user", JSON.stringify(this.user))
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
   		fetchData(cursor)
		{
			if(typeof cursor == null)
			{
				return false;
			}
			try {
				this.toast("fetching data", "blue")
                axios.post("/admin/dashboard/users/paginate", {cursor: cursor})
                .then(response => {
                	this.toast("Users returned successfully", "green")
                	this.users = response.data
            	})
                .catch( (error) => {
                	this.toast("Error occured while trying to fetch data", "red")
                })
            } catch (error) {
                this.toast("Error occured while trying to fetch data", "red")
            }
		},
		searchForUserOnRecord()
		{
			if(this.searchTerm.length >= 3)
			{
				this.safeKeepAttendance = this.users
				let users = this.searchDatabaseForUser(this.searchTerm)
				console.log(this.users)
			}else{
				this.users = this.safeKeepAttendance
			}
		}, 
		searchDatabaseForUser(searchTerm)
		{
			this.toast("Searching for user", "blue")
			axios.post("/admin/dashboard/users/search", { searchTerm: searchTerm })
			.then( ( response ) => {
				if(!response.data.error)
				{
					this.toast("Possible users returned successfully", "green")
					this.users = response.data.data
				}
			})
			.catch( (error) => {
				this.toast("Error occured while searching for user", "red")
			})
		},
		viewTicket(user)
		{
			console.log(user)
			this.rolesToAssign = this.sortRoles(user.role)
			this.chosenUser = user
			$refs.sideBarButton.dispatchEvent(new Event("click"))
		},
		sortRoles(userRoles)
		{
			let unassigedRoles = [];
			this.originalRoles.forEach((role) => {
			    if (!userRoles.some((originalRole) => originalRole.role === role.role)) {
			        unassigedRoles.push(role);
			    }
			});
			return unassigedRoles
		},
		AddRole(role)
		{
			this.toast("Modifying user role", "blue")
			try {
                axios.post("/admin/dashboard/users/roles/assign", {role: role.role, user_id: this.chosenUser.id})
                .then( ( response ) => {
                	{{-- Adapt the changes to the current dataset --}}
                	this.chosenUser.role = response.data.user.role
                	{{-- this.rolesToAssign = sortRoles(this.chosenUser.role) --}}
                	let roleIndex = this.rolesToAssign.findIndex( (roled) => roled.role == role.role)
                	this.rolesToAssign.splice(roleIndex, 1)
                	let userIndex = this.users.data.findIndex( (user) => user.id == this.chosenUser.id )
                	this.users.data.splice(userIndex, 1, this.chosenUser);
                	this.toast("User role adjusted ", "green")
            	})
                .catch( (error) => {
                	 this.toast("An error occurred while making the change in role ", "red")
                })
            } catch (error) {
                this.toast("An error occurred while making the change in role", "red")
            }
		},
		removeRole(role)
		{
			{{-- Send request --}}
			this.toast("Modifying user role .... ", "blue")
			try {
                axios.post("/admin/dashboard/users/roles/unassign", {role: role.role, user_id: this.chosenUser.id})
                .then(response => {
                	{{-- Adapt the changes to the current dataset --}}
                	this.rolesToAssign = this.sortRoles(response.data.user.role)
                	this.chosenUser.role = response.data.user.role
                	let userIndex = this.users.data.findIndex( (user) => user.id == this.chosenUser.id )
                	this.users.data.splice(userIndex, 1, this.chosenUser);
                	this.toast("User role successfully modified", "green")
            	})
                .catch((error) => {
	                this.toast("An error occurred while making the change in role", "red")
	            })
            } catch (error) {
               this.toast("An error occurred while making the change in role", "red")
            }
		}
	}'>
		<div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
			<div class="max-w-md">
				<h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
				<p class="text-md leading-7 my-4">This is the database o all the users on the platform, you can adjust their roles as required. Remember that every individual you upgrade to an admin role would also have the ability to create and manage events while users to upgrade to Organizer can only manage their own events.</p>
				<a href="/promoter/dashboard/events/create" class="px-6 py-3 font-bold md:font-normal bg-red-1000 text-gray-200">Create event</a>
			</div>
			<img src="{{asset('/images/people.svg')}}" alt="People chilling" class="w-96 h-52">
		</div>
		<div class="my-10 flex justify-between items-center">
			<h1 class="font-bold text-xl">User management dashboard</h1>
			<form action="" method="post" @submit.prevent="searchForUserOnRecord" class="flex justify-start items-center">
				<input type="text" x-model="searchTerm" id="" placeholder="e.g. Yagami" class="md:w-64 focus:outline-none focus:border focus:border-gray-300 focus:shadow-xl focus:border focus:border-gray-200 focus:ring-0" @input.debounce.500ms="searchForUserOnRecord">
				{{-- <button type="submit" class="bg-red-1000 text-gray-100 py-2 border-4 border-gray-950 px-10 border-none shadow">Search</button> --}}
			</form>
		</div>
		
		<div class="flex justify-center items-center md:mt-12 pb-12">
			<template x-if="users.data.length <= 0">
				<h3>No one yet</h3>
			</template>
			<template x-if="users.data.length > 0">
				<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-md border border-purple-200">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
					<th scope="col" class="px-6 py-3">Name</th>
					<th scope="col" class="px-6 py-3">Nickname</th>
					<th scope="col" class="px-6 py-3">Email</th>
					<th scope="col" class="px-6 py-3">Phone</th>
					<th scope="col" class="px-6 py-3">Actions</th>
				</thead>
				<tbody>
					<template x-for="user in users.data" :key="user.id">
				        <tr class="odd:bg-white odd:dark:bg-gray-900 hover:bg-purple-200 duration-200 even:bg-gray-50 even:dark:bg-gray-00 border-b border-purple-300 dark:border-gray-700">
				        	<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" x-text="user.name"></th>
			                <td class="px-6 py-4" x-text="user.nickname"></td>
			                <td class="px-6 py-4" x-text="user.email"></td>
			                <td class="px-6 py-4" x-text="user.phone"></td>
			                <td>
			                	<button class="font-bold underline text-blue-800" @click="viewTicket(user)">View roles</button>
			                </td>
						</tr>
				    </template>	
				</tbody>
			</table>
			</template>
		</div>

		{{-- Pagination link --}}
		<div class="flex justify-end gap-10 my-4">
			
			<template x-if="users.prev_cursor != null">
				<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(users.prev_cursor)">Prev</button>
			</template>
			<template x-if="users.next_cursor != null">
				<button class="px-8 py-2 bg-gray-900 text-gray-400" @click="fetchData(users.next_cursor)">Next</button>
			</template>
		</div>

		<div class="text-center hidden">
	        <button class="text-black bg-white" type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example" id="right-drawer-button" x-ref="sideBarButton">
	         Show right drawer
	         </button>
	    </div>

	      <!-- drawer component -->
	    <div id="drawer-right-example" class="fixed top-0 right-0 z-40 w-64 md:w-96 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-200 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
	        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
	            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
	            <span class="sr-only">Close menu</span>
	        </button>
	        <div class="py-4 overflow-y-auto text-black">


			<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
			    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
			        <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Roles</button>
			        </li>
			       {{--  <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Edit</button>
			        </li> --}}
			       {{--  <li class="me-2" role="presentation">
			            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="settings-styled-tab" data-tabs-target="#styled-settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Attendance</button>
			        </li> --}}
			    </ul>
			</div>
			<div id="default-styled-tab-content">
			    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
			    	
            		<template x-if="chosenUser != null">
						<ul>
							<h2 class="font-bold text-md mt-3 mb-2" x-text="chosenUser.nickname + '  s current roles'"></h2>
							<p class="grid grid-cols-3 font-bold gap-3">
								<span>Current role</span>
								<span></span>
								<span>Action</span>
							</p>
							<template x-for="role in chosenUser.role">
								<li class="grid grid-cols-3 gap-3 justify-evenly items-center py-3">
									<p x-text="role.role.toUpperCase()"></p>
									<span class="text-green-700 tracking-tightest font-bold text-sm border-none"><span >&#10003; <span>&#10003;</span></span></span>
									<div class="flex justify-start items-center font-bold text-sm tracking-wider">
										<button x-show="role.role != 'user'" @click="removeRole(role)" class="text-red-600 hover:underline hover:underline-offset-2">Remove role</button>
										
									</div>
								</li>
							</template>
						</ul>
					</template>
					<h2 class="font-bold text-md mt-10 mb-2">Unassigned roles possible for the user</h2>
					<template x-if="chosenUser != null">
						<div>
							<template x-if="rolesToAssign.length === 0">
								<p class="text-center font-bold text-md text-gray-950 py-8">User has all the possible roles already</p>
							</template>
							<template x-if="rolesToAssign.length > 0">
								<ul>
									<template x-for="role in rolesToAssign">
										<li class="grid grid-cols-2 gap-3 justify-evenly items-center py-3">
											<p x-text="role.role.toUpperCase()"></p>
											<div class="flex justify-start items-center font-bold text-sm tracking-wider">
												<button x-show="role.role != 'user'" @Click="AddRole(role)" class="text-green-600 hover:underline hover:underline-offset-2">Add role</button>
												
											</div>
										</li>
									</template>
								</ul>
							</template>
						</div>
					</template>
			    </div>
			    {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
			        Ticket form would be here
			    </div> --}}
			    {{-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-settings" role="tabpanel" aria-labelledby="settings-tab">
			       
			    </div> --}}
			</div>
	        </div>
	    </div>
	</div>

@endsection

