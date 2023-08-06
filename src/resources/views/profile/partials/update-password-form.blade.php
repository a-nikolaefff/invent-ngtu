<section>
    <header>
        <h2 class="h2">
            Изменение пароля
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Убедитесь, что вы используете длинный и безопасный пароль.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-forms.input-label for="current_password" value="Текущий пароль" />
            <x-forms.text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-forms.input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-forms.input-label for="password" value="Новый пароль" />
            <x-forms.text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-forms.input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-forms.input-label for="password_confirmation" :value="__('interface.confirm-password')" />
            <x-forms.text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-forms.input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-buttons.confirm>Изменить пароль</x-buttons.confirm>
        </div>
    </form>
</section>
