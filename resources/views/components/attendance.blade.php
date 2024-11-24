<section x-data='{ attendance: [],
		showSearchResult: false,
		ticket: JSON.parse(sessionStorage.getItem("ticket")),
		searchTerm: "",
		safeKeepAttendance: [],
		searchResult: [],
		searchForUserOnRecord()
		{
			{{-- let user = this.attendance.find( (person) => person.user.nickname == this.searchTerm) --}}
			if(this.searchTerm.length >= 3)
			{
				let user = this.attendance.filter( ( person ) => person.user.nickname.toLowerCase().includes(this.searchTerm.toLowerCase()) )
				if(user.length > 0)
				{
					this.safeKeepAttendance = this.attendance
					this.attendance = user
				}
				if(user.length == 0)
				{
					this.attendance = this.safeKeepAttendance
					user = this.searchDatabaseForUser(this.searchTerm, 1)
				}
			}else{
				this.attendance = this.safeKeepAttendance
			}
			{{-- this.attendance = this.safeKeepAttendance --}}
		}, 
		searchDatabaseForUser(nickname, ticket_id)
		{
			axios.post("/promoter/dashboard/ticket/attendance/search", { nickname: nickname, ticket_id: this.ticket.id})
			.then( ( response ) => {
				if(!response.data.error)
				{
					this.searchResult = response.data.users
				}
				this.showSearchResult = true
			})
			.catch(error => console.log(error))
		},
		markUserAsPresent(user)
		{
			{{-- alert("I work") --}}
			axios.post("/promoter/dashboard/ticket/attendance/mark", { user_id: user.user.id, ticket_id: this.ticket.id})
			.then( ( response ) => {
				if(!response.data.error)
				{
					this.attendance.unshift(user)
				}
				this.showSearchResult = false
			})
			.catch(error => console.log(error))
		}
	}' 
		class="-tracking-wider text-gray-950" 
		x-modelable="attendance"
		x-model="chosenAttendance"
>
	<form action="" method="post" @submit.prevent="searchForUserOnRecord()" class="flex justify-start items-center">
		<input type="text" x-model="searchTerm" id="" placeholder="e.g. Yagami" class="focus:outline-none focus:border-none focus:shadow-xl focus:border focus:border-gray-200 focus:ring-0" @input.debounce.500ms="searchForUserOnRecord">
		<button type="submit" class="bg-gray-950 text-gray-300 py-2 border-4 border-gray-950 px-10 border-none shadow">Search</button>
	</form>
	<div x-show="showSearchResult" class="my-6">
		<template x-if="searchResult.length == 0">
			<h3 class="font-bold text-center">No user with that name or nickname bought a ticket for this event</h3>
		</template>
		<template x-if="searchResult.length > 0">
			<ul>
				<template x-for="user in searchResult" :key="user.id">
					<li class="flex gap-4 justify-center items-center">
						<p x-text="user.user.nickname"></p>
						<p><span class="text-red-800 text-lg font-bold">&#63;</span></p>
						<button type="button" class="text-green-700 px-3 py-2" @click="markUserAsPresent(user)" title="Mark this user as present for this event">Mark as present</button>
					</li>
				</template>
			</ul>
		</template>
	</div>
	<div class="my-10">
		<template x-if="attendance.length <= 0">
			<p class="font-bold leading-9 text-md ">No one has been marked present yet</p>
		</template>
		<template x-if="attendance.length > 0">
			<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
			    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
			        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
			            <tr>
			                <th scope="col" class="px-6 py-3">
			                    Nickname
			                </th>
			                <th scope="col" class="px-6 py-3"></th>
			                <th scope="col" class="px-6 py-3">
			                    Sign in time
			                </th>
			            </tr>
			        </thead>
			        <tbody>
			        	<template x-for="person in attendance" :key="person.id">
							<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
				                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" x-text="person.user.nickname"></th>
				                <td><span class="text-green-700 tracking-tightest font-bold text-lg border-none">&#10003; &#10003;</span></td>
				                <td class="px-6 py-4" x-text="new Date(person.updated_at).toLocaleTimeString()"></td>
				            </tr>
						</template> 
			        </tbody>
			    </table>
			</div>
		</template>
	</div>
</section>



