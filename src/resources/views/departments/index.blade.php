<x-app-layout title="Подразделения">

    @if (session('status') === 'department-stored')
        <x-alert type="success" class="mb-4">
            Новое подразделение успешно добавлено
        </x-alert>
    @endif

    @if (session('status') === 'department-deleted')
        <x-alert type="success" class="mb-4">
            Подразделение удалено
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Подразделения
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                    <div class="flex mb-3">
                        <div class="w-full md:w-8/12 lg:w-1/2">
                            <x-search-form
                                :value="request()->search"
                                placeholder="Поиск по наименованию или краткому наименованию"
                            ></x-search-form>
                        </div>
                        <div></div>
                    </div>

                    <div class="flex mb-2">
                        <div class="w-full md:w-8/12 lg:w-4/12">
                            <x-input-label value="Тип подразделения" class="mb-1" />
                            <x-option-selector
                                id="optionSelector1"
                                :url="route('departments.index')"
                                parameter-name="department_type_id"
                                :options="$departmentTypes"
                                passing-property='id'
                                displaying-property='name'
                                all-options-selector='любой тип'
                                not-specified-option-selector='не задан'
                            ></x-option-selector>
                        </div>
                        <div></div>
                    </div>

                @can('create', App\Models\Department::class)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('departments.create') }}">
                                <x-button-create>
                                    Создать новое подразделение
                                </x-button-create>
                            </a>
                        </span>
                    </div>
                @endcan

                    @if($departments->count() === 0)
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
                            <th scope="col" class="w-7/12 px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('departments.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                >
                                    Наименование
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('departments.index', ['sort' => 'short_name', 'direction' => 'asc']) }}"
                                >
                                    Краткое наименование
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('departments.index', ['sort' => 'department_type_name', 'direction' => 'asc']) }}"
                                >
                                    Тип подразделения
                                </a>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($departments as $department)
                        <tr
                            onclick="window.location='{{ route('departments.show', $department->id) }}';"
                            class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">
                            <td class="px-6 py-4 max-w-250">{{ $department->name }}</td>

                            <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                @if($department->short_name)
                                    {{ $department->short_name }}
                                @else
                                    не задано
                                @endif
                            </td>

                            <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                @if($department->type)
                                    {{ $department->type->name }}
                                @else
                                    не задан
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $departments->links() }}
                    </div>

                    @endif
            </div>
        </div>
    </div>

</x-app-layout>
