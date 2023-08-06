<x-admin-layout :centered="true" :title="'Подразделение: ' . $department->name">

    @if (session('status') === 'department-updated')
        <x-alert type="success">
            Данные успешно изменены
        </x-alert>
    @endif

    <div class="page-header">
        <h1 class="h1">
            {{ 'Подразделение: ' . $department->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $department)
                <a href="{{ route('departments.edit', $department->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $department)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данное подразделения?"
                    warning="Это действие безвозвратно удалит данное подразделения.
                        После удаления у всех существующих помещений данного подразделения, подразделение не будет задано."
                    :route="route('departments.destroy', $department->id)"
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
                <td>{{ $department->name }}</td>
            </tr>
            <tr>
                <th scope="row" class="w-2/12">Краткое наименование:</th>
                <td>
                    @if($department->short_name)
                        {{ $department->short_name }}
                    @else
                        не задано
                    @endif
                </td>
            </tr>
            <tr>
                <th scope="row" class="w-2/12">Тип подразделения:</th>
                <td>
                    @if($department->type)
                        {{ $department->type->name }}
                    @else
                        не задан
                    @endif
                </td>
            </tr>
            <tr
                @if($department->parent)
                    onclick="window.location='{{ route('departments.show', $department->parent->id) }}';"
                class="standard-table__clickable-row"
                @endif
            >
                <th scope="row" class="w-2/12">
                    Родительское подразделение:
                </th>
                <td>
                    @if($department->parent)
                        {{ $department->parent->name }}
                    @else
                        нет
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    @if(($department->children->count() > 0))
        <div class="content-block">
            <h2 class="h2">
                Дочерние подразделения
            </h2>

            <table class="standard-table standard-table_clickable">
                <thead>
                <tr>
                    <th scope="col" class="w-7/12">Наименование</th>
                    <th scope="col" class="hidden md:table-cell">Краткое наименование</th>
                    <th scope="col" class="hidden md:table-cell">Тип подразделения</th>
                </tr>
                </thead>

                <tbody>
                @foreach($department->children as $child)
                    <tr
                        onclick="window.location='{{ route('departments.show', $child->id) }}';">
                        <td>{{ $child->name }}</td>

                        <td class="hidden md:table-cell">
                            @if($child->short_name)
                                {{ $child->short_name }}
                            @else
                                не задано
                            @endif
                        </td>

                        <td class="hidden md:table-cell">
                            @if($child->type)
                                {{ $child->type->name }}
                            @else
                                не задан
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="content-block">
        <h2 class="h2">
            Хронологические данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>
            <tr>
                <th scope="row" class="w-2/12">Создано:</th>
                <td> {{ $department->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение:</th>
                <td> {{ $department->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-admin-layout>
