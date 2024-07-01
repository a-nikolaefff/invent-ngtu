<section class="space-y-6">
    <header>
        <h2 class="h2">
            Удалить аккаунт
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Ваши заявки на ремонт оборудования также будут удалены. Это действие нельзя отменить.
        </p>
    </header>

    <x-buttons.delete
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Удалить аккаунт</x-buttons.delete>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Вы уверены, что вы хотите удалить ваш аккаунт?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Удалить аккаунт и все связанные с ним данные. Это действие нельзя отменить.
                <br>
                Для подтверждения удаления аккаунта введите пароль.
            </p>

            <div class="mt-6">
                <x-forms.input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-forms.text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('interface.password') }}"
                />

                <x-forms.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-buttons.cancel x-on:click="$dispatch('close')">
                    Отмена
                </x-buttons.cancel>

                <x-buttons.delete class="ml-3">
                    Удалить аккаунт
                </x-buttons.delete>
            </div>
        </form>
    </x-modal>
</section>
