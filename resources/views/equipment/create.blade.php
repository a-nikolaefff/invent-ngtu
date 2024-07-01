<x-layouts.app title="Добавление нового оборудования" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Добавление нового оборудования
        </h1>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Основные данные
        </h2>

        <form method="POST"
              action="{{ route('equipment.store') }}">
            @csrf

            <div class="form-wrapper">
                <div class="max-w-4xl">
                    <x-forms.input-label for="number" value="Инвентарный номер"/>
                    <x-forms.text-input id="number" name="number" type="text" :value="old('number')"
                                        required autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('number')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="equipment_type" value="Тип оборудования"/>
                    <select id="equipment_type" name="equipment_type_id" data-te-select-init>
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
                    <x-forms.input-error :messages="$errors->get('equipment_type_id')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="name" value="Наименование"/>
                    <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                                        required autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('name')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="description" value="Описание"/>
                    <x-forms.textarea id="description"
                                      name="description"
                                      type="text"
                                      rows="5"
                                      maxlength="200"
                    >{{ old('description') }}</x-forms.textarea>
                    <x-forms.input-error :messages="$errors->get('description')"/>
                </div>

                <div class="max-w-xl mb-3">
                    <x-forms.input-label for="datePicker1" value="Дата приобретения"/>
                    <div>
                        <x-forms.text-input id="datePicker1"
                                            name="acquisition_date"
                                            type="text"
                                            placeholder="Выберите дату приобретения"
                                            autocomplete="off"
                                            class="block w-full"
                                            :value="old('acquisition_date')"/>
                    </div>
                    <x-forms.input-error class="mt-2" :messages="$errors->get('acquisition_date')"/>
                </div>

                <div>
                    <x-forms.input-label for="roomAutocomplete" value="Местонахождение (помещение)"/>
                    <div class="flex">
                        <x-forms.text-input id="roomAutocomplete"
                                            name="room"
                                            autocomplete="off"
                                            value="{{ old('room',
                                                                    isset($chosenRoom) ? $chosenRoom->number . ' (' . $chosenRoom->building->name . ')' : null) }}"
                                            class="grow"
                        />
                        <div id="roomResetAutocomplete" class="resetAutocomplete">
                            <x-buttons.reset-icon/>
                        </div>
                    </div>

                    <input name="room_id" id="roomId" hidden="hidden"
                           value="{{ old('room_id', $chosenRoom?->id) }}">
                    <x-forms.input-error :messages="$errors->get('room_id')"/>
                </div>

                <div class="max-w-4xl mb-3">
                    <x-forms.input-label for="not_in_operation"
                                         value="Статус текущей эксплуатации (по умолчанию в эксплуатации)"/>
                    <x-forms.checkbox
                        id="not_in_operation"
                        name="not_in_operation"
                        label="не в эксплуатации"
                        checked="{{ old('not_in_operation') }}"
                    />
                    <x-forms.input-error :messages="$errors->get('not_in_operation')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="decommissioned"
                                         value="Статус на балансе университета (по умолчанию на балансе)"/>
                    <x-forms.checkbox
                        id="decommissioned"
                        name="decommissioned"
                        label="списано"
                        checked="{{ old('decommissioned') }}"
                    />
                    <x-forms.input-error :messages="$errors->get('decommissioned')"/>
                </div>

                <div class="max-w-xl @if(!old('decommissioned')) hidden @endif"
                     id="decommissioningDatePickerWrapper">
                    <x-forms.input-label for="datePicker2" value="Дата списания"/>
                    <div>
                        <x-forms.text-input id="datePicker2"
                                            name="decommissioning_date"
                                            type="text"
                                            placeholder="Выберите дату списания"
                                            autocomplete="off"
                                            class="block w-full"
                                            :value="old('decommissioning_date')"/>
                    </div>
                    <x-forms.input-error :messages="$errors->get('decommissioning_date')"/>
                </div>

                <div class="max-w-xl @if(!old('decommissioned')) hidden @endif"
                     id="decommissioningReasonWrapper">
                    <x-forms.input-label for="decommissioning_reason" value="Причина списания"/>
                    <x-forms.text-input id="decommissioning_reason" name="decommissioning_reason"
                                        type="text" :value="old('decommissioning_reason')" autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('decommissioning_reason')"/>
                </div>

                <x-buttons.confirm>
                    Добавить оборудование
                </x-buttons.confirm>
            </div>
        </form>
    </div>
</x-layouts.app>
