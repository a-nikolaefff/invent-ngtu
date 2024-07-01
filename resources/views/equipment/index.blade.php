<x-layouts.app title="Оборудование">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'equipment-deleted')
        <x-alert type="success">
            Оборудование удалено
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Оборудование
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по инв. номеру, наименованию, номеру помещения, подразделению"
    />

    <x-option-selector
        class="w-full md:w-8/12 lg:w-4/12"
        id="optionSelector1"
        label="Тип оборудования"
        :options="$equipmentTypes"
        parameter="equipment_type_id"
        passing-property='id'
        displaying-property='name'
        all-options-selection='любой тип'
        not-specified-option-selection='не задан'
    />

    <div class="md:flex mb-2">
        <div class="mb-3 w-full md:w-8/12 lg:w-4/12">
            <x-forms.input-label value="Статус текущей эксплуатации" class="mb-1"/>
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
            <x-forms.input-label value="Статус на балансе университета" class="mb-1"/>
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
        <a class="block" href="{{ route('equipment.create') }}">
            <x-buttons.create>
                добавить новое оборудование
            </x-buttons.create>
        </a>
    @endcan

    @if($equipment->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col" class="w-1/12">
                    <a href="{{ route('equipment.index', ['sort' => 'number', 'direction' => 'asc']) }}">
                        Инвентарный номер
                    </a>
                </th>

                <th scope="col" class="w-4/12">
                    <a href="{{ route('equipment.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Наименование
                    </a>
                </th>

                <th scope="col" class="w-2/12 hidden md:table-cell">
                    <a href="{{ route('equipment.index', ['sort' => 'equipment_type_name', 'direction' => 'asc']) }}">
                        Тип оборудования
                    </a>
                </th>

                <th scope="col" class="w-2/12 hidden md:table-cell">
                    <a href="{{ route('equipment.index', ['sort' => 'location', 'direction' => 'asc']) }}">
                        Местонахождение
                    </a>
                </th>

                <th scope="col" class="w-3/12 hidden lg:table-cell">
                    <a href="{{ route('equipment.index', ['sort' => 'department_name', 'direction' => 'asc']) }}">
                        Подразделение
                    </a>
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($equipment as $equipment_item)
                <tr
                    onclick="window.location='{{ route('equipment.show', $equipment_item->id) }}';">

                    <td>{{ $equipment_item->number }}</td>

                    <td>{{ $equipment_item->name }}</td>

                    <td class="hidden md:table-cell">
                        @if($equipment_item->type)
                            {{ $equipment_item->type->name }}
                        @else
                            не задан
                        @endif
                    </td>

                    <td class="hidden md:table-cell">
                        {{ $equipment_item->room->building->name . ', ' . $equipment_item->room->number }}
                    </td>

                    <td class="hidden lg:table-cell">
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
        {{ $equipment->links() }}
    @endif
</x-layouts.app>
