<x-admin-layout :title="'Подразделение: ' . $department->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status') === 'department-type-updated')
                <x-alert type="success" class="mb-4">
                    Данные успешно изменены
                </x-alert>
            @endif

            <div class="sm:px-8">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Подразделение: ' . $department->name }}
                </h1>

                @canany(['update', 'delete'], $department)
                <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('departments.edit', $department->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                    <x-button-delete-with-modal
                        question="Вы уверены, что хотите удалить данное подразделения?"
                        warning="Это действие безвозвратно удалит данное подразделения.
                        После удаления у всех существующих помещений данного подразделения, подразделение не будет задано."
                        :route="route('departments.destroy', $department->id)"
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
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Наименование:</th>
                                            <td class=" px-6 py-4"> {{ $department->name }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Краткое наименование:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $department->short_name }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип подразделения:</th>
                                            <td class=" px-6 py-4">
                                                @if($department->type)
                                                    {{ $department->type->name }}
                                                @else
                                                    не задан
                                                @endif
                                            </td>
                                        </tr>
                                        <tr
                                            @if($department->parent)
                                                onclick="window.location='{{ route('departments.show', $department->parent->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endif
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Родительское подразделение:
                                            </th>
                                            <td class=" px-6 py-4">
                                                @if($department->parent)
                                                    {{ $department->parent->name }}
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

            @if(($department->children->count() > 0))
                <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                    <div class="">
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <h2 class="mb-2 text-lg font-medium text-gray-900">
                                            Дочерние подразделения
                                        </h2>

                                        <table class=" min-w-full text-left text-sm font-light
                    mx-auto max-w-4xl w-full rounded-lg bg-white divide-y divide-gray-300
                   ">
                                            <thead class="border-b font-medium dark:border-neutral-500">
                                            <tr>
                                                <th scope="col" class="w-7/12 px-6 py-4">
                                                    Наименование
                                                </th>

                                                <th scope="col" class="px-6 py-4 hidden md:table-cell">
                                                    Краткое наименование
                                                </th>

                                                <th scope="col" class="px-6 py-4 hidden md:table-cell">
                                                    Тип подразделения
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($department->children as $child)
                                                <tr
                                                    onclick="window.location='{{ route('departments.show', $child->id) }}';"
                                                    class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">
                                                    <td class="px-6 py-4 max-w-250">{{ $child->name }}</td>

                                                    <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                                        @if($child->short_name)
                                                            {{ $child->short_name }}
                                                        @else
                                                            не задано
                                                        @endif
                                                    </td>

                                                    <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                                        @if($child->type)
                                                            {{ $child->type->name }}
                                                        @else
                                                            не задан
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

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
                                        <td class=" px-6 py-4"> {{ $department->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение:
                                        </th>
                                        <td class=" px-6 py-4"> {{ $department->updated_at }}</td>
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
</x-admin-layout>
