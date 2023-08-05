<x-app-layout title="Редактирование ремонта">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Редактирование ремонта
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
                                              action="{{ route('repairs.update', $repair->id) }}">
                                            @method('PUT')
                                            @csrf

                                            <div class="mb-3">
                                                <x-input-label for="equipmentAutocomplete" value="Ремонтируемое оборудование (инвентарный номер)"/>
                                                <div class="flex">
                                                    <x-text-input id="equipmentAutocomplete"
                                                                  name="equipment"
                                                                  autocomplete="off"
                                                                  value="{{ old('equipment', '№ ' . $repair->equipment->number . ', ' . $repair->equipment->name) }}"
                                                                  class="grow"
                                                    />

                                                    <div id="equipmentResetAutocomplete" class="resetAutocomplete">
                                                        <x-button-reset-icon/>
                                                    </div>

                                                </div>

                                                <input name="equipment_id" id="equipmentId" hidden="hidden"
                                                       value="{{ old('equipment_id', $repair->equipment->id) }}">

                                                <x-input-error class="mt-2" :messages="$errors->get('equipment_id')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="repair_type" value="Тип ремонта" class="mb-1"/>
                                                <select id="repair_type" name="repair_type_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    <option
                                                        value=" " {{ old('repair_type_id', $repair->type->id) == " " ? 'selected' : '' }}>
                                                        не задан
                                                    </option>
                                                    @foreach($repairTypes as $type)
                                                        <option
                                                            value="{{ $type->id }}" {{ old('repair_type_id', $repair->type->id) == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('repair_type_id')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="repairStatus" value="Статус ремонта" class="mb-1"/>
                                                <select id="repairStatus" name="repair_status_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    @foreach($repairStatuses as $status)
                                                        <option
                                                            value="{{ $status->id }}" {{ old('repair_status_id', $repair->status->id) == $status->id ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('repair_status_id')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="short_description" value="Краткое описание"/>
                                                <x-text-input id="short_description" name="short_description" type="text"
                                                              class="mt-1 block w-full" :value="old('short_description', $repair->short_description)"
                                                              required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('short_description')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="full_description" value="Полное описание"/>
                                                <x-textarea id="full_description"
                                                            name="full_description"
                                                            type="text"
                                                            rows="5"
                                                            maxlength="200"
                                                            class="mt-1 block w-full">{{ old('full_description', $repair->full_description) }}</x-textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('full_description')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="datePicker1" value="Дата начала"/>
                                                <x-text-input id="datePicker1"
                                                              name="start_date"
                                                              type="text"
                                                              placeholder="Выберите дату приобретения"
                                                              autocomplete="off"
                                                              class="mt-1 block w-full"
                                                              :value="old('start_date', $repair->start_date->format('d.m.Y'))"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('start_date')"/>
                                            </div>

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="datePicker2" value="Дата окончания"/>
                                                <x-text-input id="datePicker2"
                                                              name="end_date"
                                                              type="text"
                                                              placeholder="Выберите дату окончания"
                                                              autocomplete="off"
                                                              class="mt-1 block w-full"
                                                              :value="old('start_date', $repair->end_date->format('d.m.Y'))"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('end_date')"/>
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
