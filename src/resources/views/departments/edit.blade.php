<x-app-layout title="Редактирование подразделения">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Редактирование подразделения
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
                                      action="{{ route('departments.update', $department->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="max-w-4xl mb-3">
                                        <x-input-label for="name" value="Наименование"/>
                                        <x-text-input id="name" name="name" type="text"
                                                      class="mt-1 block w-full" :value="old('name', $department->name)"
                                                      required/>
                                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                    </div>

                                    <div class="max-w-xl mb-3">
                                        <x-input-label for="short_name" value="Краткое наименование"/>
                                        <x-text-input id="short_name" name="short_name" type="text"
                                                      class="mt-1 block w-full"
                                                      :value="old('short_name', $department->short_name)"
                                                      required/>
                                        <x-input-error class="mt-2" :messages="$errors->get('short_name')"/>
                                    </div>

                                    <div class="max-w-xl mb-3">
                                        <x-input-label for="department_type_id" value="Тип подразделения" class="mb-1"/>
                                        <select id="department_type" name="department_type_id"
                                                class="mb-3"
                                                data-te-select-init>
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
                                        <x-input-error class="mt-2" :messages="$errors->get('department_type_id')"/>
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="departmentAutocomplete" value="Родительское подразделение (если имеется)"/>

                                        <div class="flex">
                                            <x-text-input id="departmentAutocomplete"
                                                          name="parent_department"
                                                          class="grow"
                                                          autocomplete="off"
                                                          value="{{ isset($department->parent)
                                                            ? old('parent_department', $department->parent->name)
                                                            : old('parent_department') }}"
                                            />

                                            <div id="departmentResetAutocomplete" class="resetAutocomplete">
                                                <x-button-reset-icon/>
                                            </div>
                                        </div>

                                        <input name="parent_department_id"
                                               id="departmentId"
                                               hidden="hidden"
                                               value="{{ isset($department->parent)
                                                ? old('parent_department_id', $department->parent_department_id)
                                                : old('parent_department_id') }}"
                                        >

                                        <x-input-error class="mt-2" :messages="$errors->get('parent_department_id')"/>
                                    </div>


                                    <x-button-confirm>
                                        Подтвердить изменения
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
