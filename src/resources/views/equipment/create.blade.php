<x-app-layout title="Добавление нового оборудования">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Добавление нового оборудования
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
                                              action="{{ route('equipment.store') }}">
                                            @csrf

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="number" value="Инвентарный номер"/>
                                                <x-text-input id="number" name="number" type="text"
                                                              class="mt-1 block w-full" :value="old('number')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('number')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="equipment_type" value="Тип оборудования" class="mb-1"/>
                                                <select id="equipment_type" name="equipment_type_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    <option
                                                        value=" " {{ old('equipment_type_id') == " " ? 'selected' : '' }}>
                                                        не задан
                                                    </option>
                                                    @foreach($equipmentTypes as $type)
                                                        <option
                                                            value="{{ $type->id }}" {{ old('equipment_type_id') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('equipment_type_id')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="name" value="Наименование"/>
                                                <x-text-input id="name" name="name" type="text"
                                                              class="mt-1 block w-full" :value="old('name')"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="description" value="Описание"/>
                                                <x-textarea id="description"
                                                            name="description"
                                                            type="text"
                                                            rows="5"
                                                            maxlength="200"
                                                            class="mt-1 block w-full">{{ old('description') }}</x-textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('description')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="datePicker1" value="Дата приобретения"/>
                                                <x-text-input id="datePicker1"
                                                              name="acquisition_date"
                                                              type="text"
                                                              placeholder="Выберите дату приобретения"
                                                              autocomplete="off"
                                                              class="mt-1 block w-full"
                                                              :value="old('acquisition_date')"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('acquisition_date')"/>
                                            </div>

                                            <div class="mb-3">
                                                <x-input-label for="roomAutocomplete" value="Местонахождение (помещение)"/>
                                                <div class="flex">
                                                    <x-text-input id="roomAutocomplete"
                                                                  name="room"
                                                                  autocomplete="off"
                                                                  value="{{ old('room',
                                                                    isset($chosenRoom) ? $chosenRoom->number . ' (' . $chosenRoom->building->name . ')' : null) }}"
                                                                  class="grow"
                                                    />

                                                    <div id="roomResetAutocomplete" class="resetAutocomplete">
                                                        <x-button-reset-icon/>
                                                    </div>

                                                </div>

                                                <input name="room_id" id="roomId" hidden="hidden"
                                                       value="{{ old('room_id', $chosenRoom?->id) }}">

                                                <x-input-error class="mt-2" :messages="$errors->get('room_id')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="not_in_operation" value="Статус текущей эксплуатации (по умолчанию в эксплуатации)"
                                                               class="mb-1"/>
                                                <x-checkbox
                                                id="not_in_operation"
                                                name="not_in_operation"
                                                label="не в эксплуатации"
                                                checked="{{ old('not_in_operation') }}"
                                                />
                                                <x-input-error class="mt-2" :messages="$errors->get('not_in_operation')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="decommissioned" value="Статус на балансе университета (по умолчанию на балансе)"
                                                               class="mb-1"/>
                                                <x-checkbox
                                                    id="decommissioned"
                                                    name="decommissioned"
                                                    label="списано"
                                                    checked="{{ old('decommissioned') }}"
                                                />
                                                <x-input-error class="mt-2" :messages="$errors->get('decommissioned')"/>
                                            </div>

                                            <div class="max-w-xl mb-3 @if(!old('decommissioned')) hidden @endif" id="decommissioningDatePickerWrapper">
                                                <x-input-label for="datePicker2" value="Дата списания"/>
                                                <x-text-input id="datePicker2"
                                                              name="decommissioning_date"
                                                              type="text"
                                                              placeholder="Выберите дату списания"
                                                              autocomplete="off"
                                                              class="mt-1 block w-full"
                                                              :value="old('decommissioning_date')"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('decommissioning_date')"/>
                                            </div>

                                            <div class="max-w-xl mb-3 @if(!old('decommissioned')) hidden @endif" id="decommissioningReasonWrapper">
                                            <x-input-label for="decommissioning_reason" value="Причина списания"/>
                                            <x-text-input id="decommissioning_reason" name="decommissioning_reason" type="text"
                                                          class="mt-1 block w-full" :value="old('decommissioning_reason')"/>
                                            <x-input-error class="mt-2" :messages="$errors->get('decommissioning_reason')"/>
                                            </div>

                                            <x-button-confirm class="mt-3">
                                                Добавить оборудование
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
