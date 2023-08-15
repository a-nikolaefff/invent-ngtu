<x-layouts.admin title="Редактирование подразделения" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Редактирование подразделения
        </h1>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Основные данные
        </h2>

        <form method="POST"
              action="{{ route('departments.update', $department->id) }}">
            @method('PUT')
            @csrf

            <div class="form-wrapper">
                <div class="max-w-4xl">
                    <x-forms.input-label for="name" value="Наименование"/>
                    <x-forms.text-input id="name" name="name" type="text" :value="old('name', $department->name)"
                                        required autocomplete="off"/>
                    <x-forms.input-error class="mt-2" :messages="$errors->get('name')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="shortName" value="Краткое наименование"/>
                    <x-forms.text-input id="shortName" name="short_name" type="text"
                                        :value="old('short_name', $department->short_name)" autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('short_name')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="departmentTypeId" value="Тип подразделения"/>
                    <select id="departmentTypeId" name="department_type_id" data-te-select-init>
                        <option
                            value=" " {{ old('department_type_id', $department->department_type_id) == " " ? 'selected' : '' }}>
                            не задан
                        </option>
                        @foreach($departmentTypes as $type)
                            <option
                                value="{{ $type->id }}" {{ old('department_type_id', $department->department_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.input-error :messages="$errors->get('department_type_id')"/>
                </div>

                <div>
                    <x-forms.input-label for="departmentAutocomplete" value="Родительское подразделение (если имеется)"/>
                    <div class="flex">
                        <x-forms.text-input id="departmentAutocomplete"
                                            name="parent_department"
                                            class="grow"
                                            autocomplete="off"
                                            value="{{ isset($department->parent)
                                                            ? old('parent_department', $department->parent->name)
                                                            : old('parent_department') }}"
                        />

                        <div id="departmentResetAutocomplete" class="resetAutocomplete">
                            <x-buttons.reset-icon/>
                        </div>
                    </div>
                    <input name="parent_department_id"
                           id="departmentId"
                           hidden="hidden"
                           value="{{ isset($department->parent)
                                                ? old('parent_department_id', $department->parent_department_id)
                                                : old('parent_department_id') }}"
                    >

                    <x-forms.input-error :messages="$errors->get('parent_department_id')"/>
                </div>

                <x-buttons.confirm>
                    Подтвердить изменения
                </x-buttons.confirm>
            </div>
        </form>
    </div>

</x-layouts.admin>
