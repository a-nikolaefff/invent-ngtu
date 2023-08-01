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
