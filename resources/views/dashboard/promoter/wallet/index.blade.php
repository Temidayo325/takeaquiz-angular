@extends('layouts.admin')

@section('title', 'My wallet')

@section('content')
	<div class="grid gap-4 pt-3 px-4 pb-20 md:px-12" x-data='{user: @json($user),
        totalSales: @json($totalSales),
        monthlySales: @json($monthlySales),
        hasClickedCopy: false,
        amount: 100,
        withdrawAmount: 0,
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
                if(response.data.error)
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
        toast(text, background){
            Toastify({
                text: text, 
                style: {
                background: background,
                color: "#fff"
                }
            }).showToast();
        },
        initiateWithdrawal()
        {
            if(this.withdrawAmount > this.user.va.balance)
            {
                this.toast("You cannot withdraw above your wallet balance", "orange")
                return false;
            }
            this.toast("Making withdrawal request .... ", "blue")
            axios.post("/promoter/dashboard/wallet/withdraw", {amount: this.withdrawAmount})
            .then( ( response ) => {
                if(response.data.error)
                {
                    this.toast("Your withdrawal request has been submitted", "green")
                    this.withdrawAmount = 0
                }else{
                    this.toast(response.data.errorMessage, "orange")
                }
            })
            .catch( ( error ) => {
                this.toast(error.response.data.message, "#DB162F")
            })

        },
        init(){
        }}'>
        <div class="px-2">
            <h2 class="font-bold text-md mt-3 ">My wallet</h2>
            <div class="grid gap-5 md:gap-10  md:flex md:justify-start">
                <div class="bg-purple-1000 px-3 py-5 text-gray-200 rounded-md shadow-md mt-2 md:w-72">
                    <h3 class="text-sm">Account balance</h3>
                    <h1 class="text-5xl md:text-7xl mt-2 md:my-4">
                        <span class="text-lg">&#8358; </span>
                        <span x-text="new Intl.NumberFormat().format(user.va.balance)"></span>
                    </h1>
                </div>
                <div class="bg-yellow-300 px-3 py-5  text-purple-1000 rounded-md shadow-md mt-2 md:w-72">
                    <h3 class="text-sm">Ticket sales for this month</h3>
                    <h1 class="text-5xl md:text-7xl mt-2 md:my-4">
                        <span class="text-lg">&#8358; </span>
                        <span x-text="new Intl.NumberFormat().format(monthlySales)"></span>
                    </h1>
                </div>
                <div class="bg-red-1000 px-3 py-5  text-gray-200 rounded-md shadow-md mt-2 md:w-72">
                    <h3 class="text-sm">All time Ticket sales</h3>
                    <h1 class="text-5xl md:text-7xl mt-2 md:my-4">
                        <span class="text-lg">&#8358; </span>
                        <span x-text="new Intl.NumberFormat().format(totalSales)"></span>
                    </h1>
                </div>
            </div>
        </div>

        @if( $user->hasAnyRole('promoter') )
            <div class="md:w-2/4 mt-10 md:mt-20 bg-white py-5 md:px-6 px-2">
                <h2 class="font-bold text-md mt-3 ">Make withdrawal</h2>
                <ul class="list-none grid gap-4 md:gap-6 mt-2">
                    <li>
                        <p class="text-gray-400 text-sm">Kindly note that you cannot withdraw beyond your wallet balance.</p>
                    </li>
                    <li>
                        <input type="num" x-model="withdrawAmount" :max="user.va.balance" class="w-56 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-4/5 invalid:border-b invalid:border-red-600 placeholder:text-gray-200 block">
                        <button  @click="initiateWithdrawal()" class="bg-red-1000 text-white px-4 py-3 mt-6 rounded block">Withdraw from wallet</button>
                    </li>
                </ul>
            </div>
        @endif

        <div class="md:w-2/4 mt-10 md:mt-20 bg-white py-5 md:px-6 px-2">
            <h2 class="font-bold text-md mt-3 ">How to fund wallet</h2>
            <ul class="list-disc px-8 grid gap-4 md:gap-10 mt-2">
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
                    <p class="">You can fund your wallet using your card via a web checkout url. Add the amount you want t0 add before add and click the button to get started</p>
                    <p class="text-sm text-gray-500 py-1 mt-3">You cannot fund your wallet with amount less than #100</p>
                    <input type="number" min="100" placeholder="5000" class="w-36 border-0 border-b-2 border-gray-300 outline-none ring-0 focus:shadow-sm transition duration-500 focus:border-b focus:border-gray-500 focus:outline-none focus:ring-0 md:w-48 invalid:border-b invalid:border-red-600 placeholder:text-gray-200" x-model="amount">
                    <button @click="generateCheckoutUrl()" class="bg-red-1000 text-white px-4 py-2 mt-6 rounded">Fund wallet</button>
                </li>
            </ul>
        </div>

        @if( $user->hasAnyRole('promoter') )
            <div class="md:w-2/4 mt-10 md:mt-20 bg-white py-5 px-3 md:px-6" x-data='{beneficiary: @json($user->beneficiary),
                account_details: {account_name: null, account_number: null, bank_name: null, bank_code: null},
                errorMessage: "",
                banks: [],
                init()
                {
                    this.account_details = ( this.beneficiary == null ) ?  {account_name: null, account_number: null, bank_name: null, bank_code: null} : this.beneficiary
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
                searchBank(){
                    if(this.account_details.bank_name.length < 2)
                    {
                        return false
                    }
                    this.toast("Searching for bank .... ", "#fff", "#1d1128")
                    axios.get("/promoter/dashboard/wallet/findBank/"+this.account_details.bank_name)
                    .then( ( response ) => {
                        this.toast("Banks returned succesfully")
                        console.log(response)
                        this.banks = response.data.data
                    })
                    .catch( ( error ) => {
                        console.log(error)
                        this.toast(error.response.data.message, "#fff", "#DB162F")
                        this.errorMessage = error.response.data.message
                    })
                },
                submitPromoterAccount()
                {
                    this.toast("Creating your withdrawal account .... ", "#fff", "#1d1128")
                    axios.post("/promoter/dashboard/wallet/createBeneficiary",{...this.account_details})
                    .then( ( response ) => {
                        if(response.data.error)
                        {
                            this.toast("Withdrawal account created succesfully")
                            this.errorMessage = ""
                            this.beneficiary = response.data.beneficiary
                        }
                    })
                    .catch( ( error ) => {
                        this.toast(error.response.data.message, "#fff", "#DB162F")
                        this.errorMessage = error.response.data.message
                    })
                },
                choseBank(bank)
                {
                    this.account_details.bank_name = bank.name
                    this.account_details.bank_code = bank.code
                    this.banks = []
                }
            }'>
                <h2 class="font-bold text-xl mb-6">Set up your withdrawal account details</h2>
                <form action="" @submit.prevent="submitPromoterAccount">
                    <p x-show="errorMessage.length > 1" x-text="errorMessage" class="text-purple-1000 p-2 bg-red-300"></p>
                    <div class="grid gap-4 md:gap-8 text-purple-1000">
                        <div>
                            <label class="font-bold text-sm block" for="account_name">Account name</label>
                            <p class="text-sm text-gray-700">As appeared on your bank account. Any deviation may affect your withdrawal</p>
                            <input type="text" id="account_name" name="account_name" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full" x-model="account_details.account_name" :disabled="beneficiary != null">
                        </div>
                        <div>
                            <label class="font-bold text-sm block" for="account_number">Account number</label>
                            <input type="text" id="account_number" name="account_number" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full" x-model="account_details.account_number" :disabled="beneficiary != null">
                        </div>
                        <div class="relative">
                            <label class="font-bold text-sm block" for="bank_name">Bank name</label>
                            <input type="text" id="bank_name" name="bank_name" class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full" x-model.debounce="account_details.bank_name" @keyup.debounce.200="searchBank" :disabled="beneficiary != null">
                            <div x-show="banks.length > 0" class="absolute w-full mt-1 bg-white border rounded-md shadow-lg">
                                <ul class="divide-y divide-gray-200">
                                    <template x-for="bank in banks">
                                        <li class="p-2 hover:bg-gray-100 cursor-pointer" x-text="bank.name" @click="choseBank(bank)"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="bg-red-1000 text-white px-4 py-2 mt-6 rounded" >Add account</button> 
                </form>
            </div>


        @endif
    </div>
@endsection
