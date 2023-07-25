<x-guest-layout title="Ожидание авторизации">
    <div class="mb-4 text-sm text-gray-600 text-center">
        Ваш адрес электронной почты подтвержден!
        <br>
        Ожидайте подтверждения вашего аккаунта администратором системы.
        <br>
        Вы получите уведомление об этом на вашу электронную почту.
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md
            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('interface.log-out') }}
        </button>
    </form>
</x-guest-layout>

