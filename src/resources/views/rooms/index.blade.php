<x-app-layout title="Помещения">

    @if (session('status') === 'room-stored')
        <x-alert type="success">
            Новое помещение успешно добавлено
        </x-alert>
    @endif

    @if (session('status') === 'room-deleted')
        <x-alert type="success">
            Помещение удалено
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Помещения
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по номеру, наименованию, подразделению"
    ></x-search-form>

    <x-option-selector
        class="w-full md:w-8/12 lg:w-4/12"
        id="optionSelector1"
        label="Тип помещения"
        :options="$roomTypes"
        parameter="room_type_id"
        passing-property='id'
        displaying-property='name'
        all-options-selection='любой тип'
        not-specified-option-selection='не задан'
    />

    <div class="md:flex mb-2">
        <x-option-selector
            class="mb-3 w-full md:mb-0 md:w-8/12 lg:w-4/12"
            id="optionSelector2"
            label="Здание"
            :options="$buildings"
            parameter="building_id"
            passing-property='id'
            displaying-property='name'
            all-options-selection='любое'
        />

        <div class="md:ml-3 w-full md:w-8/12 lg:w-4/12">
            <x-forms.input-label value="Этаж" class="mb-1"/>
            <div id="optionSelector3" data-value="floor">
                <select data-te-select-init>
                    <option
                        value="allOptionsSelection">
                        любой
                    </option>
                    @for ($i = 0; $i <= $floorAmount; $i++)
                        <option
                            value="{{ $i }}">
                            {{ $i === 0 ? 'цокольный' : $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    @can('create', App\Models\Room::class)
        <a class="block" href="{{ route('rooms.create') }}">
            <x-buttons.create>
                добавить новое помещение
            </x-buttons.create>
        </a>
    @endcan

    @if($rooms->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col" class="w-1/12">
                    <a href="{{ route('rooms.index', ['sort' => 'number', 'direction' => 'asc']) }}">
                        Номер
                    </a>
                </th>

                <th scope="col" class="w-4/12">
                    <a href="{{ route('rooms.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>

                <th scope="col" class="w-2/12 hidden md:table-cell">
                    <a href="{{ route('rooms.index', ['sort' => 'room_type_name', 'direction' => 'asc']) }}">
                        Тип помещения
                    </a>
                </th>

                <th scope="col" class="w-2/12 hidden md:table-cell">
                    <a href="{{ route('rooms.index', ['sort' => 'building_name', 'direction' => 'asc']) }}">
                        Здание
                    </a>
                </th>

                <th scope="col" class="w-3/12 hidden md:table-cell">
                    <a href="{{ route('rooms.index', ['sort' => 'department_name', 'direction' => 'asc']) }}">
                        Подразделение
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr
                    onclick="window.location='{{ route('rooms.show', $room->id) }}';">

                    <td>{{ $room->number }}</td>

                    <td>{{ $room->name }}</td>

                    <td class="hidden md:table-cell">
                        @if($room->type)
                            {{ $room->type->name }}
                        @else
                            не задан
                        @endif
                    </td>

                    <td class="hidden md:table-cell">{{ $room->building->name }}</td>

                    <td class="hidden md:table-cell">
                        @if($room->department)
                            {{ $room->department->name }}
                        @else
                            не задан
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $rooms->links() }}
    @endif
</x-app-layout>
