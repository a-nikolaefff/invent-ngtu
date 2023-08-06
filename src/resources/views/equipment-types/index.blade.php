<x-app-layout title="Типы оборудования">

    @if (session('status') === 'equipment-type-stored')
        <x-alert type="success">
            Новый тип оборудования успешно добавлен
        </x-alert>
    @endif

    @if (session('status') === 'equipment-type-deleted')
        <x-alert type="success">
            Тип оборудования удален
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered ">
        <h1 class="h1">
            Типы оборудования
        </h1>
    </div>

    @can('create', App\Models\EquipmentType::class)
        <a href="{{ route('equipment-types.create') }}">
            <x-buttons.create>
                добавить новый тип
            </x-buttons.create>
        </a>
    @endcan

    @if($equipmentTypes->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('equipment-types.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($equipmentTypes as $equipmentType)
                <tr
                    onclick="window.location='{{ route('equipment-types.show', $equipmentType->id) }}';">
                    <td>{{ $equipmentType->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $equipmentTypes->links() }}
    @endif

</x-app-layout>
