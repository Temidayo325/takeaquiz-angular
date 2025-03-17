@extends('layouts.user-dashboard')

@section('title', 'My wallet')

@section('content')
	<div class="grid gap-4 pt-3 px-2 pb-20" x-data='{user: @json($user),
        hasClickedCopy: false,
        amount: 100,
        copyAccountNumber()
        {
            navigator.clipboard.writeText(this.user.va.account_number).then(() => {
                this.hasClickedCopy = true
            }).catch(err => {
                
            });
            
        },
        generateCheckoutUrl()
        {
            if(this.amount < 100)
            {
                this.toast("You cannot fund less than #100", "white", "orange")
                return false;
            }
            this.toast("Generating payment link .... ", "#fff", "green")
            axios.post("/generate/payment/checkoutUrl", {amount: this.amount})
            .then( ( response ) => {
                if(response.data.status)
                {
                    this.toast("Payment link generated ", "#fff", "green")
                    this.toast("Redirecting you to the payment link ", "#fff", "green")
                    setTimeout( () => {
                        window.open(response.data.data.checkoutUrl, "_blank")
                    }, 2000)
                }
            })
            .catch( ( error ) => {
                console.log(error)
                this.toast(error.response.data.message, "#fff", "#DB162F")
            })
        },
        toast(text, color, background){
            Toastify({
                text: text, 
                style: {
                background: background,
                color: color
                }
            }).showToast();
        },
        init(){
            console.log(this.user)
        }}'>
        <div>
            <h2 class="font-bold text-md mt-3 ">My wallet</h2>
            <div class="bg-purple-1000 px-3 py-5 text-gray-200 rounded-md shadow-md mt-2 md:w-2/5">
                <h3 class="text-sm">Account balance</h3>
                <h1 class="text-5xl mt-2">
                    <span class="text-lg">&#8358; </span>
                    <span x-text="user.va.balance" class="text-gray-200"></span>
                </h1>
            </div>
        </div>

        <div>
            <h2 class="font-bold text-2xl mt-3 ">How to fund wallet</h2>
            <ul class="list-disc px-8 grid gap-4 mt-2">
                <li>
                    <h3 class="font-bold text-sm">Fund with bank transfer</h3>
                    <p class="">You can make a transfer from any of your desired bank into your dedicated account. Your account details are below:</p>
                    <div @click="copyAccountNumber()" class="mt-3 mb-2">
                        <h4 class="font-light text-sm">Account number</h4>
                        <p class="font-bold text-sm flex justify-between items-center" >
                        <span x-text="user.va.account_number"></span>
                        
                        <svg x-show="!hasClickedCopy" x-transition class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" /></svg>
                        
                        <svg x-show="hasClickedCopy" x-transition class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg>

                        </p>
                    </div>
                    <div>
                        <h4 class="font-light text-sm">Account name</h4>
                        <p class="font-bold text-sm" x-text="user.va.account_name"></p>
                    </div>
                    <div class="mt-2">
                        <h4 class="font-light text-sm">Bank</h4>
                        <p class="font-bold text-sm" x-text="user.va.bank"></p>
                    </div>
                </li>
                <li>
                    <h3 class="font-bold text-sm">Fund with card</h3>
                    <p class="">You can fund your wallet using your card via a web checkout url. Add the amount you want to add to wallet below</p>

                    <p class="text-sm text-gray-500 py-1 mt-3">You cannot fund your wallet with amount less than #100</p>
                    <input type="number" min="100" placeholder="5000" class="w-36 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-48 invalid:border-b invalid:border-red-600 placeholder:text-gray-200" x-model="amount">
                    <button @click="generateCheckoutUrl()" class="bg-red-1000 text-white px-4 py-2 mt-6 rounded">Fund wallet</button>
                </li>
            </ul>
        </div>
    </div>
@endsection
