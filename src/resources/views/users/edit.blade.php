<x-admin-layout :title="'Редактирование пользователя: ' . $user->name" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            {{ 'Редактирование пользователя: ' . $user->name }}
        </h1>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Служебные данные
        </h2>

            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @method('PUT')
                @csrf

                <div class="form-wrapper">
                    <div class="max-w-xl">
                        <x-forms.input-label for="role" value="Роль в системе"/>
                        <select id="role" name="role_id" data-te-select-init>
                            @foreach($roles as $role)
                                <option
                                    value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-forms.input-error :messages="$errors->get('role_id')"/>
                    </div>

                    <div>
                        <x-forms.input-label for="departmentAutocomplete" value="Подразделение"/>
                        <div class="flex">
                            <x-forms.text-input id="departmentAutocomplete"
                                                name="department"
                                                class="grow"
                                                autocomplete="off"
                                                aria-labelledby="customerHelpBlock"
                                                value="{{ old('department', isset($user->department) ? $user->department->name : null) }}"
                            />
                            <div id="departmentResetAutocomplete" class="resetAutocomplete">
                                <x-buttons.reset-icon/>
                            </div>
                        </div>
                        <input name="department_id"
                               id="departmentId"
                               hidden="hidden"
                               value="{{ old('department_id', $user->department_id) }}">
                        <x-forms.input-error :messages="$errors->get('department_id')"/>
                    </div>

                    <div>
                        <x-forms.input-label for="post" value="Должность"/>
                        <x-forms.text-input id="post" name="post" type="text" :value="old('post', $user->post)"
                                            required autocomplete="off"/>
                        <x-forms.input-error class="mt-2" :messages="$errors->get('post')"/>
                    </div>
                    <x-buttons.confirm>
                        Подтвердить изменения
                    </x-buttons.confirm>
                </div>
            </form>
        </div>
</x-admin-layout>
