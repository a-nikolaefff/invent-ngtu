<x-guest-layout title="Подтверждение пароля">
    <div class="mb-4 text-sm text-gray-600">
        Пожалуйста, подтвердите свой пароль, прежде чем продолжить.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-forms.input-label for="password" value="Пароль" />

            <x-forms.text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-buttons.confirm>
                Подтвердить
            </x-buttons.confirm>
        </div>
    </form>
</x-guest-layout>
