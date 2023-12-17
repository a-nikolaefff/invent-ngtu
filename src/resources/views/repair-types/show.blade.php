<x-layouts.admin :centered="true"  :title="'Тип ремонта: ' . $repairType->name">

    @switch(session('status'))
        @case('repair-type-stored')
            <x-alert type="success">
                Новый тип ремонтов успешно добавлен
            </x-alert>
            @break

        @case('repair-type-updated')
            <x-alert type="success">
                Данные успешно изменены
            </x-alert>
            @break
    @endswitch

    <div class="page-header">
        <h1 class="h1">
            {{ 'Тип ремонта: ' . $repairType->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $repairType)
                <a href="{{ route('repair-types.edit', $repairType->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $repairType)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данный тип ремонта?"
                    warning="Это действие безвозвратно удалит данный тип ремонта. У всех существующих ремонтов с данным типом тип станет не задан."
                    :route="route('repair-types.destroy', $repairType->id)"
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
                <td> {{ $repairType->name }}</td>
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
                <td> {{ $repairType->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение:</th>
                <td> {{ $repairType->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>


</x-layouts.admin>
