<x-app-layout :centered="true" :title="'Оборудование:  инв. № ' . $equipment->number . ', ' . $equipment->name">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @switch(session('status'))
        @case('equipment-stored')
            <x-alert type="success">
                Новое оборудование успешно добавлено
            </x-alert>
            @break

        @case('equipment-updated')
            <x-alert type="success">
                Данные успешно изменены
            </x-alert>
            @break

        @case('images-stored')
            <x-alert type="success">
                Фотографии успешно загружены
            </x-alert>
            @break

        @case('image-deleted')
            <x-alert type="success">
                Фотография удалена
            </x-alert>
            @break
    @endswitch

    <div class="page-header">
        <h1 class="h1">
            {{ 'Оборудование:  инв. № ' . $equipment->number . ', ' . $equipment->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $equipment)
                <a href="{{ route('equipment.edit', $equipment->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $equipment)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данное оборудование?"
                    warning="Это действие безвозвратно удалит данное оборудование.
                        Это действие также безвозвратно удалит все ремонты и заявки на ремонт
                         относящиеся к данному оборудованию."
                    :route="route('equipment.destroy', $equipment->id)"
                >
                    Удалить
                </x-buttons.delete-with-modal>
            @endcan
        </div>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Основные данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>
            <tr>
                <th scope="row" class="w-2/12">Инвентарный номер:</th>
                <td> {{ $equipment->number }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Тип оборудования:</th>
                <td>
                    @if($equipment->type)
                        {{ $equipment->type->name }}
                    @else
                        не задан
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Наименование:</th>
                <td> {{ $equipment->name }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Описание:</th>
                <td> {{ $equipment->description }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Дата приобретения:</th>
                <td>
                    @if(isset($equipment->acquisition_date))
                        {{ $equipment->acquisition_date->format('d.m.Y') }}
                    @else
                        не задана
                    @endif
                </td>
            </tr>

            <tr
                onclick="window.location='{{ route('rooms.show', $equipment->room->id) }}';"
                class="standard-table__clickable-row">
                <th scope="row" class="w-2/12">Месторасположение:
                </th>
                <td>
                    {{ $equipment->room->number . ' (' . $equipment->room->building->name . ')' }}
                </td>
            </tr>

            <tr
                @if($equipment->room->department)
                    @can(['view'], $equipment->room->department)
                        onclick="window.location='{{ route('departments.show', $equipment->room->department->id) }}';"
                class="standard-table__clickable-row"
                @endcan
                @endif
            >
                <th scope="row" class="w-2/12">
                    Подразделение помещения:
                </th>
                <td>
                    @if($equipment->room->department)
                        {{ $equipment->room->department->name }}
                    @else
                        нет
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">
                    Статус текущей эксплуатации:
                </th>
                <td>
                    {{ $equipment->not_in_operation ? 'не в эксплуатации' : 'в эксплуатации' }}
                </td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">
                    Статус на балансе университета:
                </th>
                <td>
                    {{ $equipment->decommissioned ? 'списано' : 'на балансе' }}
                </td>
            </tr>

            @if(isset($equipment->decommissioning_date))
                <tr>
                    <th scope="row" class="w-2/12">Дата списания:</th>
                    <td>
                        {{ $equipment->decommissioning_date->format('d.m.Y') }}
                    </td>
                </tr>
            @endif

            @if(isset($equipment->decommissioning_reason))
                <tr>
                    <th scope="row" class="w-2/12">Причина списания:
                    </th>
                    <td>
                        {{ $equipment->decommissioning_reason }}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Ремонты данного оборудования
        </h2>

        <div class="flex mb-2">
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
                class="ml-3 w-full md:w-8/12 lg:w-4/12"
                id="optionSelector2"
                label="Статус ремонта"
                :options="$repairStatuses"
                parameter="repair_status_id"
                passing-property='id'
                displaying-property='name'
                all-options-selection='любой'
            />
        </div>

        <div class="my-3">
            @can('create', App\Models\Repair::class)
                <a href="{{ route('repairs.create', ['equipment_id' => $equipment->id]) }}">
                    <x-buttons.create class="mr-2 mb-3">
                        добавить новый ремонт
                    </x-buttons.create>
                </a>
            @endcan
            @can('create', App\Models\RepairApplication::class)
                <a href="{{ route('repair-applications.create', ['equipment_id' => $equipment->id]) }}">
                    <x-buttons.create>
                        Создать заявку на ремонт
                    </x-buttons.create>
                </a>
            @endcan
        </div>

        @if($repairs->count() === 0)
            <p class="block">
                Ремонтов данного оборудования не найдено
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
    </div>

    <div class="content-block">

        <h2 class="h2">
            Фотографии оборудования
        </h2>

        <x-buttons.add-files-with-modal
            description="Выберите одну или несколько фотографий. Допустимые форматы jpeg, png, gif. Размер файла не более 10Мб."
            innerButtonText="Добавить"
            :route="route('equipment.store-images', $equipment->id)"
        >
            Добавить фотографии
        </x-buttons.add-files-with-modal>

        <div data-te-lightbox-init>
            <div class="gallery">
                @foreach($equipment->getMedia('images') as $image)
                    <div class="gallery__item">
                        <div class="gallery__picture">
                            <x-buttons.delete-picture-with-modal
                                class="gallery__delete-picture-button"
                                :imageIndex="$loop->index"
                                :route="route('equipment.destroy-image', ['equipment' => $equipment->id, 'image_index' => $loop->index])"
                            />
                            <img
                                src="{{ $image->getUrl('preview') }}"
                                data-te-img="{{ $image->getUrl() }}"
                                alt="{{ 'Добавлена ' . $image->getCustomProperty('datetime') . ' пользователем ' . $image->getCustomProperty('user_name') .' (id ' . $image->getCustomProperty('user_id') . ')'}} "
                            />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="content-block">
        <h2 class="h2">
            Хронологические данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>

            <tr>
                <th scope="row" class="w-2/12">Создано:</th>
                <td> {{ $equipment->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение основных данных:</th>
                <td> {{ $equipment->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
