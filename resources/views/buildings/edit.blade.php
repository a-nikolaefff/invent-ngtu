<x-layouts.app title="Редактирование здания" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Редактирование здания
        </h1>
    </div>

    <div class="content-block">



            <form method="POST"
                  action="{{ route('buildings.update', $building->id) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-wrapper">
                    <h2 class="h2">Основные данные</h2>
                    <div class="max-w-4xl">
                        <x-forms.input-label for="name" value="Наименование"/>
                        <x-forms.text-input id="name" name="name" type="text" :value="old('name', $building->name)"
                                            required autocomplete="off"/>
                        <x-forms.input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="address" value="Адрес"/>
                        <x-forms.text-input id="address" name="address" type="text"
                                            :value="old('address', $building->address)"
                                            required autocomplete="off"/>
                        <x-forms.input-error class="mt-2" :messages="$errors->get('address')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="floorAmount" value="Количество этажей"/>
                        <x-forms.text-input id="floorAmount" name="floor_amount" type="number"
                                            :value="old('floor_amount', $building->floor_amount)" required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('floor_amount')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="building_type" value="Тип здания"/>
                        <select id="building_type" name="building_type_id" data-te-select-init>
                            <option
                                value=" " {{ old('building_type_id', $building->building_type_id) == " " ? 'selected' : '' }}>
                                не задан
                            </option>
                            @foreach($buildingTypes as $type)
                                <option
                                    value="{{ $type->id }}" {{ old('building_type_id', $building->building_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-forms.input-error :messages="$errors->get('building_type_id')"/>
                    </div>

                    <h2 class="h2 pt-4">3D модель</h2>

                    <div class="max-w-4xl">
                        <x-forms.input-label for="model"
                                             value="3D модель здания {{ $building->model ? '(обновить). Что бы сохранить прежнюю модель оставьте пустым' : '' }}"
                        />
                        <x-forms.file-input id="model" name="model" class="mt-1 block w-full"/>
                        <x-forms.input-error :messages="$errors->get('model')"/>
                    </div>

                    <div class="max-w-xl">
                        <x-forms.input-label for="model_scale" value="Коэффициент масштаба модели (приведение единицы модели к 1 метру"/>
                        <x-forms.text-input id="model_scale" name="model_scale" type="number" step="0.00000001"
                                            :value="old('model_scale', $building->model_scale)" autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('model_scale')"/>
                    </div>

                    @if($building->model)
                        <div class="max-w-4xl mb-3">
                            <x-forms.input-label for="delete_model"
                                                 value="Удалить 3D модель здания"/>
                            <x-forms.checkbox
                                id="delete_model"
                                name="delete_model"
                                label="Удалить модель"
                                :checked="false"
                            />
                            <x-forms.input-error :messages="$errors->get('not_in_operation')"/>
                        </div>
                    @endif

                    <div class="pt-4">
                        <x-buttons.confirm>Подтвердить изменения</x-buttons.confirm>
                    </div>
                </div>
            </form>
        </div>

</x-layouts.app>
