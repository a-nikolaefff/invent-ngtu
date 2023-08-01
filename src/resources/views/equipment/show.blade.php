<x-app-layout :title="'Оборудование: ' . $equipment->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status') === 'equipment-type-updated')
                <x-alert type="success" class="mb-4">
                    Данные успешно изменены
                </x-alert>
            @endif

            <div class="sm:px-8">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Оборудование: ' . $equipment->name }}
                </h1>

                @canany(['update', 'delete'], $equipment)
                    <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('equipment.edit', $equipment->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        <x-button-delete-with-modal
                            question="Вы уверены, что хотите удалить данное оборудование?"
                            warning="Это действие безвозвратно удалит данное оборудование.
                        Это действие также безвозвратно удалит все ремонты и заявки на ремонт
                         относящиеся к данному оборудованию."
                            :route="route('equipment.destroy', $equipment->id)"
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
                                            <td class="px-6 py-4"> {{ $equipment->number }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип оборудования:</th>
                                            <td class="px-6 py-4">
                                                @if($equipment->type)
                                                    {{ $equipment->type->name }}
                                                @else
                                                    не задан
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Наименование:</th>
                                            <td class="px-6 py-4"> {{ $equipment->name }}</td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Описание:</th>
                                            <td class="px-6 py-4"> {{ $equipment->description }}</td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата приобретения:</th>
                                            <td class="px-6 py-4">
                                                @if(isset($equipment->acquisition_date))
                                                    {{ $equipment->acquisition_date->format('d.m.Y') }}
                                                @else
                                                    не задана
                                                @endif
                                            </td>
                                        </tr>

                                        <tr
                                            onclick="window.location='{{ route('rooms.show', $equipment->room->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"

                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Месторасположение:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $equipment->room->number . ' (' . $equipment->room->building->name . ')' }}
                                            </td>
                                        </tr>

                                        <tr
                                            @if($equipment->room->department)
                                                @can(['view'], $equipment->room->department)
                                                    onclick="window.location='{{ route('departments.show', $equipment->room->department->id) }}';"
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
                                            <td class="px-6 py-4">
                                                @if($equipment->room->department)
                                                    {{ $equipment->room->department->name }}
                                                @else
                                                    нет
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Статус текущей эксплуатации:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $equipment->not_in_operation ? 'не в эксплуатации' : 'в эксплуатации' }}
                                            </td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Статус на балансе университета:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $equipment->decommissioned ? 'списано' : 'на балансе' }}
                                            </td>
                                        </tr>

                                        @if(isset($equipment->decommissioning_date))
                                            <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата списания:</th>
                                                <td class="px-6 py-4">
                                                    {{ $equipment->decommissioning_date->format('d.m.Y') }}
                                                </td>
                                            </tr>
                                        @endif

                                        @if(isset($equipment->decommissioning_reason))
                                            <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Причина списания:</th>
                                                <td class="px-6 py-4">
                                                    {{ $equipment->decommissioning_reason }}
                                                </td>
                                            </tr>
                                        @endif

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
                                        <td class="px-6 py-4"> {{ $equipment->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение:
                                        </th>
                                        <td class="px-6 py-4"> {{ $equipment->updated_at }}</td>
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