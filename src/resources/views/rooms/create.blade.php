<x-app-layout title="Добавление нового помещения">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Добавление нового помещения
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
                                              action="{{ route('rooms.store') }}">
                                            @csrf

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="number" value="Номер"/>
                                                <x-text-input id="number" name="number" type="text"
                                                              class="mt-1 block w-full" :value="old('number')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('number')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="name" value="Наименование"/>
                                                <x-text-input id="name" name="name" type="text"
                                                              class="mt-1 block w-full" :value="old('name')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="room_type" value="Тип помещения" class="mb-1"/>
                                                <select id="room_type" name="room_type_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    <option
                                                        value=" " {{ old('room_type_id') == " " ? 'selected' : '' }}>
                                                        не задан
                                                    </option>
                                                    @foreach($roomTypes as $type)
                                                        <option
                                                            value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('room_type_id')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="building_id" value="Здание" class="mb-1"/>
                                                <select id="building_id" name="building_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    @foreach($buildings as $building)
                                                        <option
                                                            value="{{ $building->id }}" {{ old('building_id', $chosenBuilding?->id) == $building->id ? 'selected' : '' }}>
                                                            {{ $building->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('building_id')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="floor" value="Этаж" class="mb-1"/>
                                                <select id="floor" name="floor"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    @for ($i = 0; $i <= $building->floor_amount; $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>
                                                            {{ $i === 0 ? 'цокольный' : $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('floor')"/>
                                            </div>

                                            <div class="mb-3">
                                                <x-input-label for="departmentAutocomplete" value="Подразделение (если имеется)"/>
                                                <div class="flex">
                                                    <x-text-input id="departmentAutocomplete"
                                                                  name="department"
                                                                  autocomplete="off"
                                                                  value="{{ old('department') }}"
                                                                  class="grow"
                                                    />

                                                    <div id="departmentResetAutocomplete" class="resetAutocomplete">
                                                        <x-button-reset-icon/>
                                                    </div>

                                                </div>

                                                <input name="department_id" id="departmentId" hidden="hidden"
                                                       value="{{ old('department_id') }}">

                                                <x-input-error class="mt-2" :messages="$errors->get('department_id')"/>
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
