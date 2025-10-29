<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('auth.update_password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('auth.update_password_description') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('auth.current_password')" class="dark:text-gray-300" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-blue-500 dark:focus:ring-blue-500" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 dark:text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('auth.new_password')" class="dark:text-gray-300" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-blue-500 dark:focus:ring-blue-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 dark:text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('auth.confirm_password')" class="dark:text-gray-300" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:border-blue-500 dark:focus:ring-blue-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 dark:text-red-400" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:bg-blue-700 dark:active:bg-blue-900 dark:focus:ring-offset-gray-800">{{ __('auth.save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('auth.saved') }}</p>
            @endif
        </div>
    </form>
</section>
