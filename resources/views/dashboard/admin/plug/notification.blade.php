@extends('layouts.admin')

@section('title', "View notification's request")

@section('content')
	<div class="text-purple-1000" x-data='{ summary: "",
        notifications: @json($notification),
        user: @json($user),
        init()
        {
            console.log(this.notifications)
        },
        toast(text, color, background)
		{
			Toastify({
			  text: text, 
			  style: {
			    background: background,
			    color: color
			  }
			}).showToast();
		},
        approveRequest(index, notificationId)
        {
            this.toast("Approving request ...", "white", "blue")
             axios.post("/admin/dashboard/plug/request", {notification_id: notificationId})
            .then( ( response ) => {
                console.log(response)
                if(!response.error)
                {
                    this.toast("Request to upgrade to promoter has been approved", "white", "green")
                    this.notifications.splice(index, 1)
                }
            })
            .catch( (error) => {
                console.log(error)
                this.toast(error.response.data.message, "white", "red")
            })
        }
	}'>
		<section class="mt-2 grid gap-10 md:px-10 pb-12">
            <div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
                <div class="max-w-lg">
                    <h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
                    <p class="text-md leading-7 my-4">These are users that have made the request to become plugs so that they can be able to provide more information on their services</p> 
                </div>
                <img src="{{asset('/images/plug-request.svg')}}" alt="People chilling" class="w-96 h-52">
            </div>
            <div class="md:mt-10 mb-4">
                <h2 class="font-bold font-body text-2xl">User's request</h2>
            </div>
            
           <div>
            <template x-if="notifications == null || notifications.length < 1">
                <p class="bg-purple-300 p-3 rounded text-purple-1000">No user has recently requested to become a plug</p>
            </template>
            <template x-if="notifications != null && notifications.length > 0">
                <section class="grid grid-cols-3 gap-x-4 gap-y-10 mb-12">
                    <template x-for="(notification, index) in notifications" :key="notification.id">
                        <div class="border border-gray-300 shadow-md rounded py-3 px-4 hover:shadow-2xl duration-200">
                            <p x-text="notification.user.name" class="text-sm"></p>
                            <p x-text="notification.user.nickname" class="font-bold text-2xl leading-9"></p>
                            <p class="text-sm" x-text="notification.user.email"></p>
                            <p class="text-sm" x-text="notification.user.phone"></p>
                            
                            <h3 class="font-bold mt-2">Summary</h3>
                            <p x-text="notification.summary" class="leading-8"></p>

                            <div class="flex justify-center mt-3">
                                <button class="bg-yellow-200 text-purple-1000 py-2  w-3/4 text-center hover:bg-yellow-400 duration-300 shadow-md" @click="approveRequest(index, notification.id)">Accept</button>
                            </div>
                        </div>
                    </template>
                </section>
            </template>
           </div>
		</section>
	</div>

@endsection

