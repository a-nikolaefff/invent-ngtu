<x-guest-layout title="Регистрация">
    <div class="w-full sm:max-w-5xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" value="Имя" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('interface.email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Department -->
            <div class="mt-4">
                <x-input-label for="departmentAutocomplete" value="Ваше подразделение в НГТУ им. Р.Е. Алексеева"/>

                <div class="flex">
                    <x-text-input id="departmentAutocomplete"
                                  name="department"
                                  class="grow"
                                  autocomplete="off"
                                  aria-labelledby="customerHelpBlock"
                                  value="{{ old('department') }}"
                    />

                    <div id="departmentResetAutocomplete" class="resetAutocomplete">
                        <x-button-reset-icon/>
                    </div>
                </div>

                <input name="department_id"
                       id="departmentId"
                       hidden="hidden"
                       value="{{ old('department_id') }}">

                <x-input-error class="mt-2" :messages="$errors->get('department_id')"/>
            </div>

            <!-- Post -->
            <div class="mt-4">
                <x-input-label for="post" value="Должность" />
                <x-text-input id="post" class="block mt-1 w-full" type="text" name="post" :value="old('post')" required autofocus />
                <x-input-error :messages="$errors->get('post')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('interface.password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('interface.confirm-password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Captcha -->
            <div class="mt-4 sm:flex justify-center">
                <div>
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}

                    <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    Уже зарегистрированы?
                </a>

                <x-button-confirm class="ml-4">
                    Зарегистрироваться
                </x-button-confirm>
            </div>
        </form>
    </div>
</x-guest-layout>
