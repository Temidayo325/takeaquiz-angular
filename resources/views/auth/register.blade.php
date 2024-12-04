<x-guest-layout>
    @section('title', 'Create your account')
    <h2 class="text-center font-display font-bold text-purple-1000 text-2xl tracking-wider"> Create your account</h2>
    <form method="POST" action="{{ route('register') }}" class="mt-3 mb-7">
        @csrf
        <div class="grid gap-4 md:grid-cols-2 md:gap-x-6 md:gap-y-5">
            <!-- Name -->
            <fieldset class="border border-gray-400 px-1 py-1">
                <legend class="px-2 ">Name</legend>

                <x-text-input id="name" class="block mt-1 w-full py-0" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g. Ajanlekoko Tinubu" />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </fieldset>

            <!-- Email Address -->
            <fieldset class="border border-gray-400 px-1 py-1">
                <legend class="px-2 ">Email</legend>

                <x-text-input id="email" class="block mt-1 w-full py-0" type="email" name="email" :value="old('email')" required autocomplete="email"  placeholder="e.g. tpainregime@gmail.com" />

                 <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </fieldset>

            <!-- Phone number -->
            <fieldset class="border border-gray-400 px-1 py-1">
                <legend class="px-2 ">Phone number</legend>

                <x-text-input id="phone" class="block mt-1 w-full py-0" type="tel" name="phone" :value="old('phone')" required autocomplete="phone" placeholder="07040473656"/>

                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </fieldset>

            <!-- Nickname -->
            <fieldset class="border border-gray-400 px-1 py-1">
                <legend class="px-2 ">Nickname</legend>

                <x-text-input id="nickname" class="block mt-1 w-full py-0" type="text" name="nickname" :value="old('nickname')" required autocomplete="username" placeholder="e.g. Tpain"/>

                <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
            </fieldset>

            <!-- Password -->
            <fieldset class="border border-gray-400 px-1 py-1">
                <legend class="px-2 ">Password</legend>

                <x-text-input id="password" class="block mt-1 w-full py-0"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </fieldset>

            <!-- Confirm Password -->
            <fieldset class="border border-gray-400 px-1 py-1">
                <legend class="px-2 ">Confirm Password</legend>

                <x-text-input id="password_confirmation" class="block mt-1 w-full py-0"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </fieldset>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-purple-1000 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <button class='mt-4 w-full py-3 bg-red-1000 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-purple-1000 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-300'>
            Register
        </button>
    </form>
</x-guest-layout>
