<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-blue-700">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-blue-800">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="rounded-lg"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('mahasiswa.profile.delete') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-blue-800">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-blue-800">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 p-2"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="bg-gray-300 text-gray-800 hover:bg-gray-400 transition duration-300 px-4 py-2 rounded-lg">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="bg-red-600 text-white hover:bg-red-700 transition duration-300 px-4 py-2 rounded-lg ms-3">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
