<x-layouts.admin title="Типы подразделений">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'department-type-deleted')
        <x-alert type="success">
            Тип подразделения удален
        </x-alert>
    @endif

        <div class="page-header page-header_not-centered ">
            <h1 class="h1">
                Типы подразделений
            </h1>
        </div>

    @can('create', App\Models\DepartmentType::class)
        <a href="{{ route('department-types.create') }}">
            <x-buttons.create>
                Добавить новое подразделение
            </x-buttons.create>
        </a>
    @endcan

    @if($departmentTypes->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
            <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('department-types.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($departmentTypes as $departmentType)
                <tr
                    onclick="window.location='{{ route('department-types.show', $departmentType->id) }}';">
                    <td>{{ $departmentType->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $departmentTypes->links() }}
    @endif

</x-layouts.admin>
