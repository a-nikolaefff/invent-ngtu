<x-admin-layout :title="'Редактирование типа подразделений: ' . $departmentType->name" :centered="true"
                :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            {{ 'Редактирование типа подразделений: ' . $departmentType->name }}
        </h1>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Данные
        </h2>

        <form method="POST"
              action="{{ route('department-types.update', $departmentType->id) }}">
            @method('PUT')
            @csrf

            <div class="form-wrapper">
                <div class="max-w-4xl">
                    <x-forms.input-label for="name" value="Наименование"/>
                    <x-forms.text-input id="name" name="name" type="text" :value="old('name', $departmentType->name)"
                                        required autocomplete="off"/>
                    <x-forms.input-error class="mt-2" :messages="$errors->get('name')"/>
                </div>

                <x-buttons.confirm class="mt-3">
                    Подтвердить изменения
                </x-buttons.confirm>
            </div>
        </form>
    </div>

</x-admin-layout>
