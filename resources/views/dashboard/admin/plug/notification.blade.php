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
                        <div class="bg-white shadow hover:shadow-xl border-gray-400 hover:border-gray-200 rounded-md overflow-x-hidden">
                            <div class="rounded-xl shadow-md md:w-96 md:mx-auto border-t border-gray-300">
                                <div class="flex justify-center items-center pb-4 ">
                                    <img :src=`{{asset('images')}}/${notification.user.plug.flier}` alt="" class="w-full h-24 md:h-44 rounded-tr-xl rounded-tl-xl mx-auto bg-white">
                                </div>
                                <div class="pb-3 border-b border-gray-400 text-center md:px-4">   
                                    <h3 class="font-bold text-lg tracking-wide text-center" x-text="notification.user.nickname"></h3>
                                    <p x-text="notification.user.name"></p>
                                    <p x-text="notification.user.plug.state"></p>
                                    <p class="font-bold text-purple-1000 mt-3 text-left" x-text="notification.user.plug.service"></p>
                                </div>  
                                <div class="grid mt-2 pb-4 md:px-4">
                                    <h3 class="font-bold mt-3 pb-2">Contact details</h3>
                                    <a :href=`tel:${notification.user.phone}`> 
                                        <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" /></svg>
                                        <span class="text-sm md:text-md" x-text="notification.user.phone + ' , ' + notification.user.plug.contact_whatsapp"></span>
                                    </a>
                                    <a :href="'mailto:'+ (notification.user.plug.contact_email != null ) ? notification.user.plug.contact_email : notification.user.email"> 
                                        <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" /></svg> <span x-text="( notification.user.plug.contact_email != null) ? notification.user.plug.contact_email : notification.user.email"></span>
                                    </a>
                                    <a :href="notification.user.plug.social_media_links" target="__blank"> <svg class="w-8 h-9 inline pr-3 text-purple-1000 font-bold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                                    <span x-text="notification.user.plug.social_media_links"></span>
                                    </a>
                                </div>
                                <div class="md:px-4">
                                    <h3 class="font-bold mt-3 pb-0 text-sm">Service</h3>
                                    <p class="text-gray-500" x-text="notification.user.plug.service"></p>

                                    <h3 class="font-bold text-sm mt-3">Service summary</h3>
                                    <p class="text-gray-500" x-text="notification.user.plug.service_summary"></p>

                                    <h3 class="font-bold mt-3 text-sm">Plug's Unique Selling Point</h3>
                                    <p class="text-gray-500" x-text="notification.user.plug.usp"></p>

                                </div>
                                <div class="grid mt-2 border-t border-gray-400 md:px-4">
                                    <h3 class="font-bold mt-3 text-sm">Service Availability</h3>
                                    <p class="text-gray-500" x-text="notification.user.plug.location_based"></p>

                                    <h3 class="font-bold mt-3 text-sm">State</h3>
                                    <p class="text-gray-500" x-text="notification.user.plug.state"></p>

                                    <h3 class="font-bold mt-3 text-sm">Contact Address (If location-based)</h3>
                                    <p class="text-gray-500" x-text="notification.user.plug.physical_address"></p>

                                    <h3 class="font-bold mt-3 text-sm">Available for travel ?</h3>
                                    <p class="text-gray-500" x-text="( notification.user.plug.travel == 1 ) ? 'Yes' : 'No'"></p>
                                </div>
                                <div class="grid mt-2 border-t border-gray-400 md:px-4 md:pb-5">
                                    <h3 class="font-bold mt-3 text-sm">Email</h3>
                                    <p class="text-gray-500 block" x-text="( notification.user.plug.contact_email == null ) ? notification.user.email : notification.user.plug.contact_email"></p>

                                    <h3 class="font-bold mt-3 text-sm">Website / Portfolio</h3>
                                    <a :href=" ( notification.user.plug.contact_portfolio == null) ? notification.user.plug.social_media_links : notification.user.plug.contact_portfolio" class="text-gray-500"></a>

                                    <h3 class="font-bold mt-3 text-sm">Phone / WhatsApp</h3>
                                    <a :href="'tel:' + ( notification.user.plug.contact_whatsapp == null ) ? notification.user.phone :  notification.user.plug.contact_whatsapp" class="text-gray-500" x-text="( notification.user.plug.contact_whatsapp == null ) ? notification.user.phone :  notification.user.plug.contact_whatsapp"></a>

                                    <h3 class="font-bold mt-3 text-sm">Social Media Links</h3>
                                    <a :href="notification.user.plug.social_media_links" target="__blank" class="text-gray-500" x-text="notification.user.plug.social_media_links"></a>
                                </div>
                                <div class="border border-gray-300 rounded py-3 px-4">
                                    <h3 class="font-bold mt-2">Notification Summary</h3>
                                    <p x-text="notification.summary" class="leading-8 px-2"></p>

                                    <div class="flex justify-center mt-3">
                                        <button class="bg-yellow-200 text-purple-1000 py-2  w-3/4 text-center hover:bg-yellow-400 duration-300 shadow-md" @click="approveRequest(index, notification.id)">Accept</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </section>
            </template>
           </div>
		</section>
	</div>

@endsection

