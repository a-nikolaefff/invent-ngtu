<x-layouts.admin title="Типы помещений">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif


    @if (session('status') === 'room-type-deleted')
        <x-alert type="success">
            Тип помещения удален
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Типы помещений
        </h1>
    </div>

    @can('create', App\Models\RoomType::class)
        <a href="{{ route('room-types.create') }}">
            <x-buttons.create>
                добавить новый тип
            </x-buttons.create>
        </a>
    @endcan

    @if($roomTypes->count() === 0)
        <p class="h5 ">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('room-types.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($roomTypes as $roomType)
                <tr
                    onclick="window.location='{{ route('room-types.show', $roomType->id) }}';">
                    <td>{{ $roomType->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $roomTypes->links() }}
    @endif

</x-layouts.admin>
