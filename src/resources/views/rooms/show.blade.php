<x-app-layout :title="'Помещение: ' . $room->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status') === 'room-type-updated')
                <x-alert type="success" class="mb-4">
                    Данные успешно изменены
                </x-alert>
            @endif

            <div class="sm:px-8">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Помещение: ' . $room->name }}
                </h1>

                @canany(['update', 'delete'], $room)
                    <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('rooms.edit', $room->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        <x-button-delete-with-modal
                            question="Вы уверены, что хотите удалить данное помещение?"
                            warning="Это действие безвозвратно удалит данное помещение.
                        Это действие также безвозвратно удалит всё оборудование относящееся к данному помещению."
                            :route="route('rooms.destroy', $room->id)"
                        >
                            Удалить
                        </x-button-delete-with-modal>
                    </div>
                @endcanany
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Основные данные
                                    </h2>

                                    <table class="min-w-full text-left text-sm font-light">
                                        <tbody>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Номер:</th>
                                            <td class=" px-6 py-4"> {{ $room->number }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Наименование:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $room->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип помещения:</th>
                                            <td class=" px-6 py-4">
                                                @if($room->type)
                                                    {{ $room->type->name }}
                                                @else
                                                    не задан
                                                @endif
                                            </td>
                                        </tr>

                                        <tr
                                            @can(['view'], $room->building)
                                                onclick="window.location='{{ route('buildings.show', $room->building->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endcan
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Здание:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $room->building->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Этаж:
                                            </th>
                                            <td class=" px-6 py-4">{{ $room->floor }}</td>
                                        </tr>

                                        <tr
                                            @if($room->department)
                                                @can(['view'], $room->department)
                                                    onclick="window.location='{{ route('departments.show', $room->department->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                                    hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endcan
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endif
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Подразделение:
                                            </th>
                                            <td class=" px-6 py-4">
                                                @if($room->department)
                                                    {{ $room->department->name }}
                                                @else
                                                    нет
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Оборудование в помещении
                                    </h2>

                                    @can('create', App\Models\Equipment::class)
                                        <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('equipment.create', ['room_id' => $room->id]) }}">
                                <x-button-create>
                                    добавить новое оборудование
                                </x-button-create>
                            </a>
                        </span>
                                        </div>
                                    @endcan

                                    @if(!isset($equipment))
                                        <p class="mt-5">
                                            У вас нет прав для просмотра информации об оборудовании в данном помещении.
                                        </p>
                                    @else
                                        @if($equipment->count() === 0)
                                            <p class="mt-5">
                                                Оборудования в данном помещении не найдено
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
                                                           href="{{ route('equipment.index', ['sort' => 'number', 'direction' => 'asc']) }}"
                                                        >
                                                            Инвентарный номер
                                                        </a>
                                                    </th>

                                                    <th scope="col" class="w-4/12 px-6 py-4">
                                                        <a class="d-block"
                                                           href="{{ route('equipment.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                                        >
                                                            Наименование
                                                        </a>
                                                    </th>

                                                    <th scope="col" class="w-2/12 px-6 py-4 hidden md:table-cell">
                                                        <a class="d-block"
                                                           href="{{ route('equipment.index', ['sort' => 'equipment_type_name', 'direction' => 'asc']) }}"
                                                        >
                                                            Тип оборудования
                                                        </a>
                                                    </th>

                                                </tr>

                                                </thead>

                                                <tbody>
                                                @foreach($equipment as $equipment_item)
                                                    <tr
                                                        onclick="window.location='{{ route('equipment.show', $equipment_item->id) }}';"
                                                        class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                                                        <td class="px-6 py-4 max-w-250">{{ $equipment_item->number }}</td>

                                                        <td class="px-6 py-4 max-w-250">{{ $equipment_item->name }}</td>

                                                        <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                                            @if($equipment_item->type)
                                                                {{ $equipment_item->type->name }}
                                                            @else
                                                                не задан
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                            <div class="mt-3">
                                                {{ $equipment->links() }}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <h2 class="mb-2 text-lg font-medium text-gray-900">
                                    Хронологические данные
                                </h2>

                                <table class="min-w-full text-left text-sm font-light">
                                    <tbody>

                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="w-2/12 px-2 py-4 text-right">Создано:</th>
                                        <td class=" px-6 py-4"> {{ $room->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение:
                                        </th>
                                        <td class=" px-6 py-4"> {{ $room->updated_at }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
