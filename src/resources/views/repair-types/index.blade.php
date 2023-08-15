<x-layouts.app title="Типы ремонтов">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'repair-type-deleted')
        <x-alert type="success">
            Тип ремонта удален
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Типы ремонтов
        </h1>
    </div>

    @can('create', App\Models\RepairType::class)
        <a href="{{ route('repair-types.create') }}">
            <x-buttons.create>
                Добавить новый тип
            </x-buttons.create>
        </a>
    @endcan

    @if($repairTypes->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('repair-types.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($repairTypes as $repairType)
                <tr
                    onclick="window.location='{{ route('repair-types.show', $repairType->id) }}';">
                    <td>{{ $repairType->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $repairTypes->links() }}
    @endif

</x-layouts.app>
