<x-app-layout :centered="true"  :title="'Тип помещений: ' . $roomType->name">

    @if (session('status') === 'room-type-updated')
        <x-alert type="success" class="mb-4">
            Данные успешно изменены
        </x-alert>
    @endif

    <div class="page-header">
        <h1 class="h1">
            {{ 'Тип помещений: ' . $roomType->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $roomType)
                <a href="{{ route('room-types.edit', $roomType->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $roomType)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данный тип здания?"
                    warning="Это действие удалит данный тип здания,
                        у всех существующих зданий данным типом тип будет не задан."
                    :route="route('room-types.destroy', $roomType->id)"
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
                <th scope="row" class="w-1/12">Наименование:</th>
                <td> {{ $roomType->name }}</td>
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
                <td> {{ $roomType->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение:</th>
                <td> {{ $roomType->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
