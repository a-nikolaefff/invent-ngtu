<x-layouts.app title="Ремонты оборудования">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @if (session('status') === 'repair-deleted')
        <x-alert type="success">
            Ремонт удален
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Ремонты оборудования
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по описанию ремонта, инв. номеру или наименованию оборудования"
    />

    <div class="md:flex mb-2">
        <x-option-selector
            class="w-full md:w-8/12 lg:w-4/12"
            id="optionSelector1"
            label="Тип ремонта"
            :options="$repairTypes"
            parameter="repair_type_id"
            passing-property='id'
            displaying-property='name'
            all-options-selection='любой'
            not-specified-option-selection='не задан'
        />

        <x-option-selector
            class="md:ml-3 w-full md:w-8/12 lg:w-4/12"
            id="optionSelector2"
            label="Статус ремонта"
            :options="$repairStatuses"
            parameter="repair_status_id"
            passing-property='id'
            displaying-property='name'
            all-options-selection='любой'
        />
    </div>


    @can('create', App\Models\Repair::class)
        <a class="block" href="{{ route('repairs.create') }}">
            <x-buttons.create>
                Добавить новый ремонт
            </x-buttons.create>
        </a>
    @endcan

    @if($repairs->count() === 0)
        <p class="block ">
            Результаты не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col" class="w-5/12">
                    <a href="{{ route('repairs.index', ['sort' => 'short_description', 'direction' => 'asc']) }}">
                        Краткое описание ремонта
                    </a>
                </th>

                <th scope="col" class="w-3/12">
                    <a href="{{ route('repairs.index', ['sort' => 'equipment_name', 'direction' => 'asc']) }}">
                        Ремонтируемое оборудование
                    </a>
                </th>

                <th scope="col" class="w-1/12 hidden lg:table-cell">
                    <a href="{{ route('repairs.index', ['sort' => 'start_date', 'direction' => 'asc']) }}">
                        Дата начала
                    </a>
                </th>

                <th scope="col" class="w-1/12 hidden lg:table-cell">
                    <a href="{{ route('repairs.index', ['sort' => 'end_date', 'direction' => 'asc']) }}">
                        Дата окончания
                    </a>
                </th>

                <th scope="col" class="w-1/12 hidden md:table-cell">
                    <a href="{{ route('repairs.index', ['sort' => 'repair_type_name', 'direction' => 'asc']) }}">
                        Тип ремонта
                    </a>
                </th>

                <th scope="col" class="w-1/12 hidden md:table-cell">
                    <a href="{{ route('repairs.index', ['sort' => 'repair_status_id', 'direction' => 'asc']) }}">
                        Статус ремонта
                    </a>
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($repairs as $repair)
                <tr
                    onclick="window.location='{{ route('repairs.show', $repair->id) }}';">

                    <td>{{ $repair->short_description }}</td>

                    <td>{{ $repair->equipment->name . ', инв. № ' . $repair->equipment->number }}</td>

                    <td class="hidden lg:table-cell">
                        @if($repair->start_date)
                            {{ $repair->start_date->format('d.m.Y') }}
                        @else
                            не задана
                        @endif
                    </td>

                    <td class="hidden lg:table-cell">
                        @if($repair->end_date)
                            {{ $repair->end_date->format('d.m.Y') }}
                        @else
                            не задана
                        @endif
                    </td>

                    <td class="hidden md:table-cell">
                        @if($repair->type)
                            {{ $repair->type->name }}
                        @else
                            не задан
                        @endif
                    </td>

                    <td class="hidden md:table-cell">
                        {{ $repair->status->name }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $repairs->links() }}
    @endif
</x-layouts.app>
