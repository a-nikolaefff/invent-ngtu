<x-layouts.app title="Добавление нового здания" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Добавление нового здания
        </h1>
    </div>

    <div class="content-block">

        <h2 class="mb-2 text-lg font-medium text-gray-900">
            Основные данные
        </h2>

            <form method="POST"
                  action="{{ route('buildings.store') }}">
                @csrf

                <div class="form-wrapper">
                    <div class="max-w-4xl">
                        <x-forms.input-label for="name" value="Наименование"/>
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name')"
                                            required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('name')"/>
                    </div>

                    <div class="max-w-4xl">
                        <x-forms.input-label for="address" value="Адрес"/>
                        <x-forms.text-input id="address" name="address" type="text" :value="old('address')"
                                            required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('address')"/>
                    </div>

                    <div class="max-w-4xl">
                        <x-forms.input-label for="floorAmount" value="Количество этажей"/>
                        <x-forms.text-input id="floorAmount" name="floor_amount" type="number"
                                            :value="old('floor_amount')" required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('floor_amount')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="buildingTypeId" value="Тип здания" class="mb-1"/>
                        <select id="buildingTypeId" name="building_type_id" data-te-select-init>
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
                        <x-forms.input-error :messages="$errors->get('building_type_id')"/>
                    </div>

                    <x-buttons.confirm>
                        Добавить здание
                    </x-buttons.confirm>
                </div>
            </form>
        </div>
</x-layouts.app>
