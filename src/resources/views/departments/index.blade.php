<x-admin-layout title="Подразделения">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'department-stored')
        <x-alert type="success">
            Новое подразделение успешно добавлено
        </x-alert>
    @endif

    @if (session('status') === 'department-deleted')
        <x-alert type="success">
            Подразделение удалено
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Подразделения
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по наименованию или краткому наименованию"
    ></x-search-form>

    <x-option-selector
        class="w-full md:w-8/12 lg:w-4/12"
        id="optionSelector1"
        label="Тип подразделения"
        :options="$departmentTypes"
        parameter="department_type_id"
        passing-property='id'
        displaying-property='name'
        all-options-selection='любой тип'
        not-specified-option-selection='не задан'
    />

    @can('create', App\Models\Department::class)
        <a class="block" href="{{ route('departments.create') }}">
            <x-buttons.create>
                Добавить новое подразделение
            </x-buttons.create>
        </a>
    @endcan

    @if($departments->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col" class="w-7/12">
                    <a href="{{ route('departments.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>

                <th scope="col" class="hidden md:table-cell">
                    <a href="{{ route('departments.index', ['sort' => 'short_name', 'direction' => 'asc']) }}">
                        Краткое наименование
                    </a>
                </th>

                <th scope="col" class="hidden md:table-cell">
                    <a href="{{ route('departments.index', ['sort' => 'department_type_name', 'direction' => 'asc']) }}">
                        Тип подразделения
                    </a>
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($departments as $department)
                <tr onclick="window.location='{{ route('departments.show', $department->id) }}';">

                    <td>{{ $department->name }}</td>

                    <td class="hidden md:table-cell">
                        @isset($department->short_name)
                            {{ $department->short_name }}
                        @else
                            не задано
                        @endisset
                    </td>

                    <td class="hidden md:table-cell">
                        @isset($department->type)
                            {{ $department->type->name }}
                        @else
                            не задано
                        @endisset
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $departments->links() }}
    @endif

</x-admin-layout>
