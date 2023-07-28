<x-app-layout title="Помещения">

    @if (session('status') === 'room-stored')
        <x-alert type="success" class="mb-4">
            Новое помещение успешно добавлено
        </x-alert>
    @endif

    @if (session('status') === 'room-deleted')
        <x-alert type="success" class="mb-4">
            Помещение удалено
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Помещения
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                    <div class="flex mb-3">
                        <div class="w-full md:w-8/12 lg:w-1/2">
                            <x-search-form
                                :value="request()->search"
                                placeholder="Поиск по номеру, наименованию или подразделению"
                            ></x-search-form>
                        </div>
                        <div></div>
                    </div>

                    <div class="flex mb-2">
                        <div class="w-full md:w-8/12 lg:w-4/12">
                            <x-input-label value="Тип помещения" class="mb-1" />
                            <x-option-selector
                                id="optionSelector1"
                                :url="route('rooms.index')"
                                parameter-name="room_type_id"
                                :options="$roomTypes"
                                passing-property='id'
                                displaying-property='name'
                                all-options-selector='любой тип'
                                not-specified-option-selector='не задан'
                            ></x-option-selector>
                        </div>
                        <div></div>
                    </div>

                <div class="flex mb-2">
                    <div class="w-full md:w-8/12 lg:w-4/12">
                        <x-input-label value="Здание" class="mb-1" />
                        <x-option-selector
                            id="optionSelector2"
                            :url="route('rooms.index')"
                            parameter-name="building_id"
                            :options="$buildings"
                            passing-property='id'
                            displaying-property='name'
                            all-options-selector='любое'
                        ></x-option-selector>
                    </div>
                    <div></div>
                </div>

                @can('create', App\Models\Room::class)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('rooms.create') }}">
                                <x-button-create>
                                    Создать новое помещение
                                </x-button-create>
                            </a>
                        </span>
                    </div>
                @endcan

                    @if($rooms->count() === 0)
                        <p class="h5 ">
                            Результаты не найдены
                        </p>
                    @else

                    <table class=" min-w-full text-left text-sm font-light
                    mx-auto max-w-4xl w-full rounded-lg bg-white divide-y divide-gray-300
                   "
                           id="sortableTable">
                        <thead class="border-b font-medium dark:border-neutral-500">
                        <tr>
                            <th scope="col" class="w-1/12 px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('rooms.index', ['sort' => 'number', 'direction' => 'asc']) }}"
                                >
                                    Номер
                                </a>
                            </th>

                            <th scope="col" class="w-4/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('rooms.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                >
                                    Наименование
                                </a>
                            </th>

                            <th scope="col" class="w-3/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('rooms.index', ['sort' => 'department_name', 'direction' => 'asc']) }}"
                                >
                                    Подразделение
                                </a>
                            </th>

                            <th scope="col" class="w-2/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('rooms.index', ['sort' => 'building_name', 'direction' => 'asc']) }}"
                                >
                                    Здание
                                </a>
                            </th>

                            <th scope="col" class="w-2/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('rooms.index', ['sort' => 'room_type_name', 'direction' => 'asc']) }}"
                                >
                                    Тип помещения
                                </a>
                            </th>

                        </tr>

                        </thead>

                        <tbody>
                        @foreach($rooms as $room)
                        <tr
                            onclick="window.location='{{ route('rooms.show', $room->id) }}';"
                            class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                            <td class="px-6 py-4 max-w-250">{{ $room->number }}</td>

                            <td class="px-6 py-4 max-w-250">{{ $room->name }}</td>

                            <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                @if($room->department->type)
                                    {{ $room->department->name }}
                                @else
                                    не задан
                                @endif
                            </td>

                            <td class="px-6 py-4 max-w-250">{{ $room->building->name }}</td>

                            <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                @if($room->type)
                                    {{ $room->type->name }}
                                @else
                                    не задан
                                @endif
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $rooms->links() }}
                    </div>

                    @endif
            </div>
        </div>
    </div>

</x-app-layout>
