<x-app-layout :title="'Редактирование типа помещений: ' . $roomType->name" :centered="true" :overflowXAuto="false">

    <div class="page-header">
        <h1 class="h1">
            {{ 'Редактирование типа помещений: ' . $roomType->name }}
        </h1>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Данные
        </h2>

            <form method="POST"
                  action="{{ route('room-types.update', $roomType->id) }}">
                @method('PUT')
                @csrf

                <div class="form-wrapper">
                    <div class="max-w-4xl">
                        <x-forms.input-label for="name" value="Наименование"/>
                        <x-forms.text-input id="name" name="name" type="text"
                                            :value="old('name', $roomType->name)"
                                            required autocomplete="off"/>
                        <x-forms.input-error :messages="$errors->get('name')"/>
                    </div>

                    <x-buttons.confirm>
                        Подтвердить изменения
                    </x-buttons.confirm>
                </div>
            </form>
        </div>
</x-app-layout>
