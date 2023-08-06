<x-app-layout title="Редактирование ремонта" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Редактирование ремонта
        </h1>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Основные данные
        </h2>

        <form method="POST"
              action="{{ route('repairs.update', $repair->id) }}">
            @method('PUT')
            @csrf

            <div class="form-wrapper">
                <div>
                    <x-forms.input-label for="equipmentAutocomplete"
                                         value="Ремонтируемое оборудование (инвентарный номер)"/>
                    <div class="flex">
                        <x-forms.text-input id="equipmentAutocomplete"
                                            name="equipment"
                                            autocomplete="off"
                                            value="{{ old('equipment', '№ ' . $repair->equipment->number . ', ' . $repair->equipment->name) }}"
                                            class="grow"
                        />

                        <div id="equipmentResetAutocomplete" class="resetAutocomplete">
                            <x-buttons.reset-icon/>
                        </div>
                    </div>
                    <input name="equipment_id" id="equipmentId" hidden="hidden"
                           value="{{ old('equipment_id', $repair->equipment->id) }}">
                    <x-forms.input-error :messages="$errors->get('equipment_id')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="repairType" value="Тип ремонта"/>
                    <select id="repairType" name="repair_type_id" data-te-select-init>
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
                    <x-forms.input-error :messages="$errors->get('repair_type_id')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="repairStatus" value="Статус ремонта" class="mb-1"/>
                    <select id="repairStatus" name="repair_status_id" data-te-select-init>
                        @foreach($repairStatuses as $status)
                            <option
                                value="{{ $status->id }}" {{ old('repair_status_id', $repair->status->id) == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.input-error :messages="$errors->get('repair_status_id')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="shortDescription" value="Краткое описание"/>
                    <x-forms.text-input id="shortDescription" name="short_description" type="text"
                                        :value="old('short_description', $repair->short_description)" required/>
                    <x-forms.input-error :messages="$errors->get('short_description')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="fullDescription" value="Полное описание"/>
                    <x-forms.textarea id="fullDescription"
                                      name="full_description"
                                      type="text"
                                      rows="5"
                                      maxlength="200"
                    >{{ old('full_description', $repair->full_description) }}</x-forms.textarea>
                    <x-forms.input-error :messages="$errors->get('full_description')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="datePicker1" value="Дата начала"/>
                    <div>
                        <x-forms.text-input id="datePicker1"
                                            name="start_date"
                                            type="text"
                                            placeholder="Выберите дату приобретения"
                                            autocomplete="off"
                                            class="block w-full"
                                            :value="old('start_date', $repair->start_date->format('d.m.Y'))"/>
                    </div>
                    <x-forms.input-error :messages="$errors->get('start_date')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="datePicker2" value="Дата окончания"/>
                    <div>
                        <x-forms.text-input id="datePicker2"
                                            name="end_date"
                                            type="text"
                                            placeholder="Выберите дату окончания"
                                            autocomplete="off"
                                            class="block w-full"
                                            :value="old('start_date', $repair->end_date->format('d.m.Y'))"/>
                    </div>
                    <x-forms.input-error :messages="$errors->get('end_date')"/>
                </div>

                <x-buttons.confirm>
                    Подтвердить изменения
                </x-buttons.confirm>
            </div>
        </form>
    </div>
</x-app-layout>
