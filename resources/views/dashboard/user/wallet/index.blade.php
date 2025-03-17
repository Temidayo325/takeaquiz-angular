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

        <x-fund-wallet></x-fund-wallet>
    </div>
@endsection
