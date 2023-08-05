<x-app-layout title="Создание новой заявки на ремонт оборудования">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Создание новой заявки на ремонт оборудования
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
                                              action="{{ route('repair-applications.store') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <x-input-label for="equipmentAutocomplete" value="Неисправное оборудование (инвентарный номер)"/>
                                                <div class="flex">
                                                    <x-text-input id="equipmentAutocomplete"
                                                                  name="equipment"
                                                                  autocomplete="off"
                                                                  value="{{ old('equipment',
                                                                    isset($chosenEquipment) ? $chosenEquipment->number . ' (' . $chosenEquipment->name . ')' : null) }}"
                                                                  class="grow"
                                                                  required
                                                    />

                                                    <div id="equipmentResetAutocomplete" class="resetAutocomplete">
                                                        <x-button-reset-icon/>
                                                    </div>

                                                </div>

                                                <input name="equipment_id" id="equipmentId" hidden="hidden"
                                                       value="{{ old('equipment_id', $chosenEquipment?->id) }}">

                                                <x-input-error class="mt-2" :messages="$errors->get('equipment_id')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="short_description" value="Краткое описание заявки"/>
                                                <x-text-input id="short_description" name="short_description" type="text"
                                                              class="mt-1 block w-full" :value="old('short_description')"
                                                              autocomplete="off" required/>
                                                <x-input-error class="mt-2" :messages="$errors->get('short_description')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="full_description" value="Расширенное описание заявки"/>
                                                <x-textarea id="full_description"
                                                            name="full_description"
                                                            type="text"
                                                            rows="5"
                                                            maxlength="555"
                                                            class="mt-1 block w-full">{{ old('full_description') }}</x-textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('full_description')"/>
                                            </div>

                                            <x-button-confirm class="mt-3">
                                                Отправить заявку
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
