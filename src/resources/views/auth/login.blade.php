<x-layouts.guest title="Вход">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-forms.input-label for="email" :value="__('interface.email')" />
                <x-forms.text-input id="email" class="block mt-1 w-full" type="email"
                              name="email" :value="old('email')"
                              required autofocus autocomplete="username" />
                <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-forms.input-label for="password" value="Пароль" />

                <x-forms.text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />

                <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Забыли ваш пароль?
                    </a>
                @endif

                <x-buttons.confirm class="ml-3">
                    Войти
                </x-buttons.confirm>
            </div>
        </form>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="flex items-center justify-end">
            <span class="text-sm text-gray-600 mr-2">
                Еще не зарегистрированы?
            </span>

            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none
        focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('register') }}">
                Создайте аккаунт
            </a>
        </div>
    </div>
</x-layouts.guest>
