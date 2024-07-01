<x-layouts.admin title="Типы зданий">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'building-type-deleted')
        <x-alert type="success">
            Тип здания удален
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Типы зданий
        </h1>
    </div>

    @can('create', App\Models\BuildingType::class)
        <a href="{{ route('building-types.create') }}">
            <x-buttons.create>
                добавить новый тип
            </x-buttons.create>
        </a>
    @endcan

    @if($buildingTypes->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('building-types.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($buildingTypes as $buildingType)
                <tr
                    onclick="window.location='{{ route('building-types.show', $buildingType->id) }}';">
                    <td>{{ $buildingType->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $buildingTypes->links() }}
    @endif
</x-layouts.admin>
