@extends('layouts.admin')

@section('title', "View Wallet request")

@section('content')
	<div class="text-purple-1000" x-data='{ summary: "",
        notifications: @json($notification),
        user: @json($user),
        amount: "",
        index: 0,
        hasRequestedOtp: false,
        userToProcess: null,
        otp: "",
        init()
        {
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
        completeWithdrawal()
        {
            this.toast("Completing  ...", "blue")
             axios.post("/admin/dashboard/wallet/withdrawal/initialize", {user_id: this.userToProcess.id, otp: this.otp, amount: this.amount})
            .then( ( response ) => {
                if(!response.error)
                {
                    this.toast("Withdrawal request succesfully granted", "green")
                    this.notifications.splice(index, 1)
                    this.hasRequestedOtp = false
                }
            })
            .catch( (error) => {
                this.toast(error.response.data.message, "red")
            })
        },
        initializeWithdrawal(notification, index)
        {
            this.userToProcess = notification.user
            this.amount = notification.summary
            this.index = index
            this.toast("Initializing the withdrawal process ...", "blue")
            axios.post("/admin/dashboard/wallet/withdrawal/initialize", {notification_id: notification.id})
            .then( ( response ) => {
                if(!response.data.error)
                {
                    this.toast("Process initialized, enter OTP to complete request", "green")
                    this.hasRequestedOtp = true
                }
                this.toast(response.data.errorMessage, "green")
            })
            .catch( (error) => {
                this.toast(error.response.data.message, "red")
            })
        }
	}'>
		<section class="mt-2 grid gap-10 md:px-10 pb-12">
            <div class="hidden md:flex py-6 md:py-10 bg-purple-300 items-center justify-between md:px-12 px-4 shadow-lg border border-purple-200">
                <div class="max-w-lg">
                    <h1 class="font-display text-2xl tracking-wider md:text-4xl font-normal">Welcome back Legend <span x-text="user.nickname"></span></h1>
                    <p class="text-md leading-7 my-4">These are users that have made the request to withdraw from their wallet</p> 
                </div>
                <img src="{{asset('/images/withdraw.svg')}}" alt="People chilling" class="w-96 h-52">
            </div>
            <div class="md:mt-10 mb-4">
                <h2 class="font-bold font-body text-2xl">Withdrawal request</h2>
            </div>
            
           <div>
            <template x-if="notifications == null || notifications.length < 1">
                <p class="bg-purple-300 p-3 rounded text-purple-1000">No Organizer has made a withdrawal request</p>
            </template>
            <template x-if="notifications != null && notifications.length > 0">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">S/N</th>
                                <th scope="col" class="px-6 py-3">Name of Organizer</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Wallet balance</th>
                                <th scope="col" class="px-6 py-3">Withrawal amount</th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                           <template x-for="(notification, index) in notifications" :key="index">
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4" x-text="index+1"></td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" x-text="notification.user.name"></th>
                                    <td class="px-6 py-4" x-text="notification.user.email"></td>
                                    <td class="px-6 py-4" x-text="new Intl.NumberFormat().format(notification.user.va.balance)"></td>
                                    <td class="px-6 py-4" x-text="new Intl.NumberFormat().format(notification.summary)"></td>
                                    <td class="px-6 py-4 text-right">
                                        <button x-show="!hasRequestedOtp" @click="initializeWithdrawal(notification, index)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Disburse Funds</button>
                                        <div x-show="hasRequestedOtp" class="flex justify-start items-baseline">
                                            <input type="tel"  class="w-24 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 invalid:border-b invalid:border-red-600 placeholder:text-gray-200" placeholder="1234" x-model="otp">
                                            <button @click="completeWithdrawal()" class="font-medium text-gray-200 dark:text-blue-500 hover:underline bg-purple-1000 py-2 px-4">Complete transaction</button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>
           </div>
		</section>
	</div>

@endsection

