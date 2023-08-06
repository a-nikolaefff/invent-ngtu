<x-guest-layout title="Восстановление пароля">
    <div class="mb-4 text-sm text-gray-600">
        Забыли пароль? Просто сообщите нам свой адрес электронной почты,
        и мы отправим вам ссылку для сброса пароля, которая позволит вам выбрать новый.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('interface.email')" />
            <x-forms.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                          required autofocus />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-buttons.confirm>
                Отправить ссылку для сброса пароля
            </x-buttons.confirm>
        </div>
    </form>
</x-guest-layout>
