<x-guest-layout>
    <div class="mb-4 text-sm text-purple-1000 leading-7 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mb-10">
        @csrf

        <!-- Email Address -->
        <fieldset class="border border-gray-400 px-2 py-2 mt-7">
            <legend class="px-2 ">Email</legend>

            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="e.g. adamu4gate@gmail.com"/>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />  
        </fieldset>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
