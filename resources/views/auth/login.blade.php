<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @section('title', 'Login to your dashboard')
    <div class="flex justify-center">
        <a href="/" class="text-center mb-3"><x-application-logo></x-application-logo></a>
    </div>
    <h2 x-data='{user: {}, 
        init(){
            this.user = JSON.parse(localStorage.getItem("user"))
    }}' class="text-center font-display font-bold text-purple-1000 text-3xl tracking-wider">Welcome back <span x-text="user != null ? user.nickname : ''"></span></h2>
    <form method="POST" action="{{ route('login') }}" class="text-purple-1000 mt-3" 
            x-data='{showPasswordToggle: true,
                    passwordType: "password",
                    togglePasswordView()
                    {
                        this.passwordType = (this.showPasswordToggle) ? "text" : "password"
                        this.showPasswordToggle = !this.showPasswordToggle
                    }
            }'>
        @csrf

        <!-- Email Address -->
        <div>
            
            <fieldset class="border border-gray-400 px-2 py-2">
                <legend class="px-2 ">Email</legend>

                <x-text-input id="email" class="block mt-1 w-full py-0 invalid:border invalid:border-red-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="e.g. adamu4gate@gmail.com" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </fieldset>
            
        </div>

        <!-- Password -->
        <fieldset class="border border-gray-400 px-2 py-2 mt-7">
            <legend class="px-2 ">Password</legend>

           <div class="relative ">
                <input :type="passwordType" 
                            class="border-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-none dark:focus:border-indigo-600 focus:ring-0 focus:shadow-xl dark:focus:ring-indigo-600 rounded-md shadow-md block mt-1 w-full py-0" 
                            name="password"
                            placeholder="e.g. *********** "
                            required 
                            autocomplete="current-password" />
                <svg x-show="showPasswordToggle" @click="togglePasswordView()" class="w-6 h-5 cursor-pointer text-purple-1000 absolute right-0 top-0 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                <svg x-show="!showPasswordToggle" @click="togglePasswordView()" class="w-6 h-5 cursor-pointer text-purple-1000 absolute right-0 top-0 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>

           </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />              
        </fieldset>

        <!-- Remember Me -->
        <div class="block mt-6 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center ">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-purple-1000 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-purple-1000 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-center mt-4">
            <button class='w-full py-3 bg-red-1000 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-purple-1000 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-300'>
                Log in
            </button>
        </div>
    </form>

    <p class="text-purple-1000 text-center text-sm mt-5 ">Don't have an account yet ? Click <a class="font-bold underline" href="/register">here</a> to create an account.</p>
</x-guest-layout>
