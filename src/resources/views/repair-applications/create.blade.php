<x-app-layout title="Создание новой заявки на ремонт оборудования" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Создание новой заявки на ремонт оборудования
        </h1>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Основные данные
        </h2>

        <form method="POST"
              action="{{ route('repair-applications.store') }}">
            @csrf

            <div class="form-wrapper">
                <div>
                    <x-forms.input-label for="equipmentAutocomplete" value="Неисправное оборудование (инвентарный номер)"/>
                    <div class="flex">
                        <x-forms.text-input id="equipmentAutocomplete"
                                            name="equipment"
                                            autocomplete="off"
                                            value="{{ old('equipment', isset($chosenEquipment) ? $chosenEquipment->number . ' (' . $chosenEquipment->name . ')' : null) }}"
                                            class="grow"
                                            required
                        />
                        <div id="equipmentResetAutocomplete" class="resetAutocomplete">
                            <x-buttons.reset-icon/>
                        </div>
                    </div>
                    <input name="equipment_id" id="equipmentId" hidden="hidden"
                           value="{{ old('equipment_id', $chosenEquipment?->id) }}">

                    <x-forms.input-error :messages="$errors->get('equipment_id')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="shortDescription" value="Краткое описание заявки"/>
                    <x-forms.text-input id="shortDescription" name="short_description" type="text"
                                        :value="old('short_description')" autocomplete="off" required/>
                    <x-forms.input-error :messages="$errors->get('short_description')"/>
                </div>

                <div class="max-w-4xl">
                    <x-forms.input-label for="fullDescription" value="Расширенное описание заявки"/>
                    <x-forms.textarea id="fullDescription"
                                      name="full_description"
                                      type="text"
                                      rows="5"
                                      maxlength="555"
                    >{{ old('full_description') }}</x-forms.textarea>
                    <x-forms.input-error :messages="$errors->get('full_description')"/>
                </div>

                <x-buttons.confirm>
                    Отправить заявку
                </x-buttons.confirm>
            </div>
        </form>
    </div>
</x-app-layout>
