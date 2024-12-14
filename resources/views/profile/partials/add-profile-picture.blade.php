<section>
    <header>
        <h2 class="text-lg font-medium text-purple-1000 dark:text-gray-100">
            {{ __('My Cruise Face-card') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __(" Add your facecard wey your face show and your shoe shine, as per OG wey you be.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update.facecard') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="facecard" :value="__('My Face card')" />
            {{-- <input id="facecard" name="facecard" type="file" class="mt-1 block w-full" required autofocus autocomplete="facecard" /> --}}
            <input type="file" name="facecard" id="facecard" required class="w-56 border border-gray-300 shadow-md focus:shadow-lg transition duration-500 focus:border-gray-500 focus:outline-none focus:ring-0 md:w-full">
            <x-input-error class="mt-2" :messages="$errors->get('facecard')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Add my face card') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
