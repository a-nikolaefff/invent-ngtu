<x-layouts.app :centered="true" :title="'Тип зданий: ' . $buildingType->name">

    @switch(session('status'))
        @case('building-type-stored')
            <x-alert type="success">
                Новый тип зданий успешно добавлен
            </x-alert>
            @break

        @case('building-type-updated')
            <x-alert type="success">
                Данные успешно изменены
            </x-alert>
            @break
    @endswitch

    <div class="page-header">
        <h1 class="h1">
            {{ 'Тип зданий: ' . $buildingType->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $buildingType)
                <a href="{{ route('building-types.edit', $buildingType->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $buildingType)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данный тип здания?"
                    warning="Это действие удалит данный тип здания. У всех существующих зданий с данным типом тип станет не задан."
                    :route="route('building-types.destroy', $buildingType->id)"
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
                <td> {{ $buildingType->name }}</td>
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
                <td>{{ $buildingType->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение:</th>
                <td> {{ $buildingType->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-layouts.app>
