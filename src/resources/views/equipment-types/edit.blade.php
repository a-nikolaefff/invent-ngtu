<x-admin-layout :title="'Редактирование типа оборудования: ' . $equipmentType->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Редактирование типа оборудования: ' . $equipmentType->name }}
                </h1>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Данные
                                    </h2>

                                    <div>
                                        <form method="POST"
                                              action="{{ route('equipment-types.update', $equipmentType->id) }}">
                                            @method('PUT')
                                            @csrf

                                            <x-input-label for="name" value="Наименование"/>

                                            <x-text-input id="name" name="name" type="text"
                                                          class="mt-1 block w-full" :value="old('name', $equipmentType->name)"
                                                          required autocomplete="off"/>

                                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>

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
