<x-admin-layout :title="'Редактирование пользователя: ' . $user->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Редактирование пользователя: ' . $user->name }}
                </h1>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Служебные данные
                                    </h2>

                                    <div>
                                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                                            @method('PUT')
                                            @csrf
                                            <x-input-label for="role" value="Роль в системе"/>

                                            <select id="role" name="role_id"
                                                    class="mb-3"
                                                    data-te-select-init>
                                                @foreach($roles as $role)
                                                    <option
                                                        value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <x-input-error class="mt-2" :messages="$errors->get('role_id')"/>
                                            <x-button-confirm class="mt-3">
                                                Подтвердить изменения
                                            </x-button-confirm>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
