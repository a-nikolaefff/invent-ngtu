<x-app-layout :centered="true" :title="'Тип оборудования: ' . $equipmentType->name">

    @switch(session('status'))
        @case('equipment-type-stored')
            <x-alert type="success">
                Новый тип оборудования успешно добавлен
            </x-alert>
            @break

        @case('equipment-type-updated')
            <x-alert type="success">
                Данные успешно изменены
            </x-alert>
            @break
    @endswitch

    <div class="page-header">
        <h1 class="h1">
            {{ 'Тип оборудования: ' . $equipmentType->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $equipmentType)
                <a href="{{ route('equipment-types.edit', $equipmentType->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $equipmentType)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данный тип здания?"
                    warning="Это действие удалит данный тип здания,
                        у всех существующих зданий данным типом тип будет не задан."
                    :route="route('equipment-types.destroy', $equipmentType->id)"
                >
                    Удалить
                </x-buttons.delete-with-modal>
            @endcan
        </div>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Основные данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>
            <tr>
                <th scope="row" class="w-1/12 px-2 py-4 text-right">Наименование:</th>
                <td class=" px-6 py-4"> {{ $equipmentType->name }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Хронологические данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>

            <tr>
                <th scope="row" class="w-2/12">Создан:</th>
                <td> {{ $equipmentType->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение:</th>
                <td> {{ $equipmentType->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
