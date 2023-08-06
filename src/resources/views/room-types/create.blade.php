<x-app-layout title="Добавление нового типа помещений" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            Добавление нового типа помещений
        </h1>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Данные
        </h2>

            <form method="POST"
                  action="{{ route('room-types.store') }}">
                @csrf

                <div class="form-wrapper">
                    <div class="max-w-4xl">
                        <x-forms.input-label for="name" value="Наименование"/>
                        <x-forms.text-input id="name" name="name" type="text"
                                            :value="old('name')" required/>
                        <x-forms.input-error :messages="$errors->get('name')"/>
                    </div>

                    <x-buttons.confirm>
                        добавить тип помещения
                    </x-buttons.confirm>
                </div>
            </form>
        </div>
</x-app-layout>
