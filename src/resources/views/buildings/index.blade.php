<x-layouts.app title="Здания">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'building-deleted')
        <x-alert type="success">
            Здание удалено
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Здания
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по наименованию"
    />

    <x-option-selector
        class="w-full md:w-8/12 lg:w-4/12"
        id="optionSelector1"
        label="Тип здания"
        :options="$buildingTypes"
        parameter="building_type_id"
        passing-property='id'
        displaying-property='name'
        all-options-selection='любой тип'
        not-specified-option-selection='не задан'
    />

    @can('create', App\Models\Building::class)
        <a class="block" href="{{ route('buildings.create') }}">
            <x-buttons.create>
                добавить новое здание
            </x-buttons.create>
        </a>
    @endcan

    @if($buildings->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col" class="w-7/12">
                    <a href="{{ route('buildings.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>

                <th scope="col">
                    <a href="{{ route('buildings.index', ['sort' => 'floor_amount', 'direction' => 'asc']) }}">
                        Количество этажей
                    </a>
                </th>

                <th scope="col" class="hidden md:table-cell">
                    <a href="{{ route('buildings.index', ['sort' => 'building_type_name', 'direction' => 'asc']) }}">
                        Тип здания
                    </a>
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($buildings as $building)
                <tr
                    onclick="window.location='{{ route('buildings.show', $building->id) }}';">

                    <td>{{ $building->name }}</td>

                    <td>{{ $building->floor_amount }}</td>

                    <td class="hidden md:table-cell">
                        @if($building->type)
                            {{ $building->type->name }}
                        @else
                            не задан
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $buildings->links() }}
    @endif
</x-layouts.app>
