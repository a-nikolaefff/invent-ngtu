<x-layouts.app title="Редактирование помещения" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Редактирование помещения
        </h1>
    </div>

    <div class="content-block">

        <h2 class="mb-2 text-lg font-medium text-gray-900">
            Основные данные
        </h2>

            <form method="POST"
                  action="{{ route('rooms.update', $room->id) }}">
                @method('PUT')
                @csrf

                <div class="form-wrapper">
                    <div class="max-w-4xl">
                        <x-forms.input-label for="number" value="Номер"/>
                        <x-forms.text-input id="number" name="number" type="text" :value="old('number', $room->number)"
                                            required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('number')"/>
                    </div>

                    <div class="max-w-4xl">
                        <x-forms.input-label for="name" value="Наименование"/>
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name', $room->name)"
                                            required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('name')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="roomType" value="Тип помещения"/>
                        <select id="roomType" name="room_type_id" data-te-select-init>
                            <option
                                value=" " {{ old('room_type_id', $room->room_type_id) == " " ? 'selected' : '' }}>
                                не задан
                            </option>
                            @foreach($roomTypes as $type)
                                <option
                                    value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-forms.input-error :messages="$errors->get('room_type_id')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="buildingId" value="Здание" />
                        <select id="buildingId" name="building_id" data-te-select-init>
                            @foreach($buildings as $building)
                                <option
                                    value="{{ $building->id }}" {{ old('building_id', $room->building_id) == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-forms.input-error :messages="$errors->get('building_id')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="floor" value="Этаж"/>
                        <select id="floor" name="floor" data-te-select-init>
                            @for ($i = 0; $i <= $building->floor_amount; $i++)
                                <option
                                    value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>
                                    {{ $i === 0 ? 'цокольный' : $i }}
                                </option>
                            @endfor
                        </select>
                        <x-forms.input-error :messages="$errors->get('floor')"/>
                    </div>

                    <div>
                        <x-forms.input-label for="departmentAutocomplete" value="Подразделение (если имеется)"/>
                        <div class="flex">
                            <x-forms.text-input id="departmentAutocomplete"
                                                name="department"
                                                class="grow"
                                                autocomplete="off"
                                                value="{{ isset($room->department)
                                                            ? old('department', $room->department->name)
                                                            : old('department') }}"
                            />
                            <div id="departmentResetAutocomplete" class="resetAutocomplete">
                                <x-buttons.reset-icon/>
                            </div>
                        </div>
                        <input name="department_id"
                               id="departmentId"
                               hidden="hidden"
                               value="{{ isset($room->department)
                                                ? old('department_id', $room->department_id)
                                                : old('department_id') }}"
                        >
                        <x-forms.input-error :messages="$errors->get('department_id')"/>
                    </div>

                    <x-buttons.confirm>
                        Подтвердить изменения
                    </x-buttons.confirm>
                </div>
            </form>
        </div>
</x-layouts.app>
