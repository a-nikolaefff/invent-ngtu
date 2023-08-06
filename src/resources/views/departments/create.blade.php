<x-admin-layout title="Добавление нового подразделения" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Добавление нового подразделения
        </h1>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Основные данные
        </h2>

        <form method="POST"
              action="{{ route('departments.store') }}">
            @csrf

            <div class="form-wrapper">
                <div class="max-w-4xl">
                    <x-forms.input-label for="name" value="Наименование"/>
                    <x-forms.text-input id="name" name="name" type="text" :value="old('name')" required autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('name')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="shortName" value="Краткое наименование"/>
                    <x-forms.text-input id="shortName" name="short_name" type="text" :value="old('short_name')" autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('short_name')"/>
                </div>

                <div class="max-w-xl">
                    <x-forms.input-label for="departmentType" value="Тип подразделения"/>
                    <select id="departmentType" name="department_type_id" data-te-select-init>
                        <option value=" " {{ old('department_type_id') == " " ? 'selected' : '' }}>
                            не задан
                        </option>
                        @foreach($departmentTypes as $type)
                            <option
                                value="{{ $type->id }}" {{ old('department_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.input-error :messages="$errors->get('department_type_id')"/>
                </div>

                <div>
                    <x-forms.input-label for="departmentAutocomplete" value="Родительское подразделение (если имеется)"/>
                    <div class="flex">
                        <x-forms.text-input id="departmentAutocomplete" name="parent_department"
                                            value="{{ old('parent_department') }}" class="grow" autocomplete="off"/>
                        <div id="departmentResetAutocomplete" class="resetAutocomplete">
                            <x-buttons.reset-icon/>
                        </div>
                    </div>
                    <input name="parent_department_id" id="departmentId" hidden="hidden"
                           value="{{ old('parent_department_id') }}">
                    <x-forms.input-error :messages="$errors->get('parent_department_id')"/>
                </div>

                <x-buttons.confirm>
                    Добавить подразделение
                </x-buttons.confirm>
            </div>
        </form>
    </div>

</x-admin-layout>
