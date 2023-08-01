<x-app-layout title="Оборудование">

    @if (session('status') === 'equipment-stored')
        <x-alert type="success" class="mb-4">
            Новое оборудование успешно добавлено
        </x-alert>
    @endif

    @if (session('status') === 'equipment-deleted')
        <x-alert type="success" class="mb-4">
            Оборудование удалено
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Оборудование
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                <div class="flex mb-3">
                    <div class="w-full md:w-8/12 lg:w-1/2">
                        <x-search-form
                            :value="request()->search"
                            placeholder="Поиск по инв. номеру, наименованию, номеру помещения, подразделению"
                        ></x-search-form>
                    </div>
                    <div></div>
                </div>

                <div class="flex mb-2">
                    <div class="w-full md:w-8/12 lg:w-4/12">
                        <x-input-label value="Тип оборудования" class="mb-1"/>
                        <x-option-selector
                            id="optionSelector1"
                            :url="route('equipment.index')"
                            parameter-name="equipment_type_id"
                            :options="$equipmentTypes"
                            passing-property='id'
                            displaying-property='name'
                            all-options-selector='любой тип'
                            not-specified-option-selector='не задан'
                        ></x-option-selector>
                    </div>
                    <div></div>
                </div>

                <div class="md:flex mb-2">

                    <div class="mb-3 w-full md:w-8/12 lg:w-4/12">
                        <x-input-label value="Статус текущей эксплуатации" class="mb-1"/>
                        <div id="optionSelector2" data-value="not_in_operation">
                            <select data-te-select-init>
                                <option
                                    value="allOptionsSelection">
                                    любой
                                </option>
                                <option
                                    value="false">
                                    в эксплуатации
                                </option>
                                <option
                                    value="true">
                                    не в эксплуатации
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="md:ml-3 w-full md:w-8/12 lg:w-4/12">
                        <x-input-label value="Статус на балансе университета" class="mb-1"/>
                        <div id="optionSelector3" data-value="decommissioned">
                            <select data-te-select-init>
                                <option
                                    value="allOptionsSelection">
                                    любой
                                </option>
                                <option
                                    value="false">
                                    на балансе
                                </option>
                                <option
                                    value="true">
                                    списанное
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                @can('create', App\Models\Equipment::class)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('equipment.create') }}">
                                <x-button-create>
                                    добавить новое оборудование
                                </x-button-create>
                            </a>
                        </span>
                    </div>
                @endcan

                @if($equipment->count() === 0)
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

                            <th scope="col" class="w-2/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('equipment.index', ['sort' => 'location', 'direction' => 'asc']) }}"
                                >
                                    Местонахождение
                                </a>
                            </th>

                            <th scope="col" class="w-3/12 px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('equipment.index', ['sort' => 'department_name', 'direction' => 'asc']) }}"
                                >
                                    Подразделение
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


                                <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                    {{ $equipment_item->room->building->name . ', ' . $equipment_item->room->number }}
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden lg:table-cell">
                                    @if($equipment_item->room->department)
                                        {{ $equipment_item->room->department->name }}
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
            </div>
        </div>
    </div>

</x-app-layout>
