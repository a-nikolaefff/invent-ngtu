<x-guest-layout title="Подтверждение email">
    <div class="mb-4 text-sm text-gray-600 text-center">
        Спасибо за регистрацию!
        <br>
        Прежде чем начать, пожалуйста, подтвердите свой адрес электронной почты,
        перейдя по ссылке, которую мы только что отправили вам по электронной почте.
        <br>
        Если вы не получили электронное письмо, нажмите на кнопку ниже, что бы отправить новое письмо.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="mr-2">
                <x-primary-button>
                    Отправить новое письмо
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('interface.log-out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
