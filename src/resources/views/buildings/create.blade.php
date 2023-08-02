<x-app-layout title="Добавление нового подразделения">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Добавление нового здания
                </h1>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">
                        <div class="sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Основные данные
                                    </h2>

                                    <div>
                                        <form method="POST"
                                              action="{{ route('buildings.store') }}">
                                            @csrf

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="name" value="Наименование"/>
                                                <x-text-input id="name" name="name" type="text"
                                                              class="mt-1 block w-full" :value="old('name')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="address" value="Адрес"/>
                                                <x-text-input id="address" name="address" type="text"
                                                              class="mt-1 block w-full" :value="old('address')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('address')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="floor_amount" value="Количество этажей"/>
                                                <x-text-input id="floor_amount" name="floor_amount" type="number"
                                                              class="mt-1 block w-full" :value="old('floor_amount')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('floor_amount')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="building_type_id" value="Тип здания" class="mb-1"/>
                                                <select id="building_type" name="building_type_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    <option
                                                        value=" " {{ old('building_type_id') == " " ? 'selected' : '' }}>
                                                        не задан
                                                    </option>
                                                    @foreach($buildingTypes as $type)
                                                        <option
                                                            value="{{ $type->id }}" {{ old('building_type_id') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('building_type_id')"/>
                                            </div>

                                            <x-button-confirm>
                                                Добавить подразделение
                                            </x-button-confirm>
                                        </form>
                                    </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
