<x-layouts.admin :centered="true" :title="'Тип подразделений: ' . $departmentType->name">

    @switch(session('status'))
        @case('department-type-stored')
            <x-alert type="success">
                Новый тип подразделения успешно добавлен
            </x-alert>
            @break

        @case('department-type-updated')
            <x-alert type="success">
                Данные успешно изменены
            </x-alert>
            @break
    @endswitch

    <div class="page-header">
        <h1 class="h1">
            {{ 'Тип подразделений: ' . $departmentType->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $departmentType)
                <a href="{{ route('department-types.edit', $departmentType->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $departmentType)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данный тип подразделений?"
                    warning="Это действие безвозвратно удалит данный тип подразделений. У всех существующих подразделений с данным типом тип станет не задан."
                    :route="route('department-types.destroy', $departmentType->id)"
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
                <th scope="row" class="w-2/12">Наименование:</th>
                <td> {{ $departmentType->name }}</td>
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
                <td> {{ $departmentType->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение:</th>
                <td> {{ $departmentType->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-layouts.admin>
