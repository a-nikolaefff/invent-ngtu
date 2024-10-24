<x-layouts.admin title="Добавление нового типа помещений" :centered="true" :overflowXAuto="false">

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
                                            :value="old('name')" required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('name')"/>
                    </div>
                    <div class="max-w-30">
                        <x-forms.input-label for="color-picker" value="Цвет помещений на 3D модели"/>
                        <div>
                            <input type="text" data-coloris id="color-picker" name="model_color">
                        </div>
                    </div>

                    <div class="pt-4">
                        <x-buttons.confirm>добавить тип помещения</x-buttons.confirm>
                    </div>
                </div>
            </form>
        </div>
</x-layouts.admin>
