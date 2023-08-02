<x-app-layout :title="'Тип помещений: ' . $roomType->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status') === 'room-type-updated')
                <x-alert type="success" class="mb-4">
                    Данные успешно изменены
                </x-alert>
            @endif

            <div class="sm:px-8">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Тип помещений: ' . $roomType->name }}
                </h1>

                <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('room-types.edit', $roomType->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                    <x-button-delete-with-modal
                        question="Вы уверены, что хотите удалить данный тип здания?"
                        warning="Это действие удалит данный тип здания,
                        у всех существующих зданий данным типом тип будет не задан."
                        :route="route('room-types.destroy', $roomType->id)"
                    >
                        Удалить
                    </x-button-delete-with-modal>
                </div>
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
                                            <th scope="row" class="w-1/12 px-2 py-4 text-right">Наименование:</th>
                                            <td class=" px-6 py-4"> {{ $roomType->name }}</td>
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
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Создан:</th>
                                            <td class=" px-6 py-4"> {{ $roomType->created_at }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="px-2 py-4 text-right">Последнее изменение:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $roomType->updated_at }}</td>
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
