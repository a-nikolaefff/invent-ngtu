<x-app-layout title="Ремонты оборудования">

    @if (session('status') === 'repair-stored')
        <x-alert type="success" class="mb-4">
            Новый ремонт успешно добавлен
        </x-alert>
    @endif

    @if (session('status') === 'repair-deleted')
        <x-alert type="success" class="mb-4">
            Ремонт удален
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Ремонты оборудования
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                <div class="flex mb-3">
                    <div class="w-full md:w-8/12 lg:w-1/2">
                        <x-search-form
                            :value="request()->search"
                            placeholder="Поиск по описанию ремонта, инв. номеру или наименованию оборудования"
                        ></x-search-form>
                    </div>
                    <div></div>
                </div>

                <div class="md:flex mb-2">

                    <div class="w-full md:w-8/12 lg:w-4/12">
                        <x-input-label value="Тип ремонта" class="mb-1"/>
                        <x-option-selector
                            id="optionSelector1"
                            :url="route('repairs.index')"
                            parameter-name="repair_type_id"
                            :options="$repairTypes"
                            passing-property='id'
                            displaying-property='name'
                            all-options-selector='любой'
                            not-specified-option-selector='не задан'
                        ></x-option-selector>
                    </div>

                    <div class="md:ml-3 w-full md:w-8/12 lg:w-4/12">
                        <x-input-label value="Статус ремонта" class="mb-1"/>
                        <x-option-selector
                            id="optionSelector2"
                            :url="route('repairs.index')"
                            parameter-name="repair_status_id"
                            :options="$repairStatuses"
                            passing-property='id'
                            displaying-property='name'
                            all-options-selector='любой'
                        ></x-option-selector>
                    </div>
                    `
                </div>

                @can('create', App\Models\Repair::class)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('repairs.create') }}">
                                <x-button-create>
                                    Добавить новый ремонт
                                </x-button-create>
                            </a>
                        </span>
                    </div>
                @endcan

                @if($repairs->count() === 0)
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
                            <th scope="col" class="w-5/12 px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('repairs.index', ['sort' => 'short_description', 'direction' => 'asc']) }}"
                                >
                                    Краткое описание ремонта
                                </a>
                            </th>

                            <th scope="col" class="w-3/12 px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('repairs.index', ['sort' => 'equipment_name', 'direction' => 'asc']) }}"
                                >
                                    Ремонтируемое оборудование
                                </a>
                            </th>

                            <th scope="col" class="w-1/12 px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('repairs.index', ['sort' => 'start_date', 'direction' => 'asc']) }}"
                                >
                                    Дата начала
                                </a>
                            </th>

                            <th scope="col" class="w-1/12 px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('repairs.index', ['sort' => 'end_date', 'direction' => 'asc']) }}"
                                >
                                    Дата окончания
                                </a>
                            </th>

                            <th scope="col" class="w-1/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('repairs.index', ['sort' => 'repair_type_name', 'direction' => 'asc']) }}"
                                >
                                    Тип ремонта
                                </a>
                            </th>

                            <th scope="col" class="w-1/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('repairs.index', ['sort' => 'repair_status_id', 'direction' => 'asc']) }}"
                                >
                                    Статус ремонта
                                </a>
                            </th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($repairs as $repair)
                            <tr
                                onclick="window.location='{{ route('repairs.show', $repair->id) }}';"
                                class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                                <td class="px-6 py-4 max-w-250">{{ $repair->short_description }}</td>

                                <td class="px-6 py-4 max-w-250">
                                    {{ $repair->equipment->name . ', инв. № ' . $repair->equipment->number }}
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden lg:table-cell">
                                    @if($repair->start_date)
                                        {{ $repair->start_date->format('d.m.Y') }}
                                    @else
                                        не задана
                                    @endif
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden lg:table-cell">
                                    @if($repair->end_date)
                                        {{ $repair->end_date->format('d.m.Y') }}
                                    @else
                                        не задана
                                    @endif
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                    @if($repair->type)
                                        {{ $repair->type->name }}
                                    @else
                                        не задан
                                    @endif
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                    {{ $repair->status->name }}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $repairs->links() }}
                    </div>

                @endif
            </div>
        </div>
    </div>

</x-app-layout>
