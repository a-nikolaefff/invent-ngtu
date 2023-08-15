<x-layouts.app title="Добавление нового типа оборудования" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Добавление нового типа ремонта
        </h1>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Данные
        </h2>

        <form method="POST"
              action="{{ route('repair-types.store') }}">
            @csrf

            <div class="form-wrapper">
                <div class="max-w-4xl">
                    <x-forms.input-label for="name" value="Наименование"/>
                    <x-forms.text-input id="name" name="name" type="text"
                                        :value="old('name')" required autocomplete="off"/>
                    <x-forms.input-error :messages="$errors->get('name')"/>
                </div>

                <x-buttons.confirm>
                    добавить тип ремонта
                </x-buttons.confirm>
            </div>
        </form>
    </div>

</x-layouts.app>
