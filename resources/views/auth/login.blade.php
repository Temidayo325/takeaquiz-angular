<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @section('title', 'Login to your dashboard')
    <h2 x-data='{user: {}, 
        init(){
            this.user = JSON.parse(localStorage.getItem("user"))
    }}' class="text-center font-display font-bold text-purple-1000 text-3xl tracking-wider">Welcome back <span x-text="user != null ? user.nickname : ''"></span></h2>
    <form method="POST" action="{{ route('login') }}" class="text-purple-1000 mt-3">
        @csrf

        <!-- Email Address -->
        <div>
            
            <fieldset class="border border-gray-400 px-2 py-2">
                <legend class="px-2 ">Email</legend>

                <x-text-input id="email" class="block mt-1 w-full py-0" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="e.g. adamu4gate@gmail.com" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </fieldset>
            
        </div>

        <!-- Password -->
        <fieldset class="border border-gray-400 px-2 py-2 mt-7">
            <legend class="px-2 ">Password</legend>

            <x-text-input id="password" class="block mt-1 w-full py-0"
                            type="password"
                            name="password"
                            placeholder="e.g. *********** "
                            required autocomplete="current-password" />

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
