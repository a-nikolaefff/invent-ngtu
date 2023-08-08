<x-app-layout :centered="true" :title="'Помещение: ' . $room->name">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @switch(session('status'))
        @case('room-stored')
            <x-alert type="success">
                Новое помещение успешно добавлено
            </x-alert>
            @break

        @case('room-updated')
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
            {{ 'Помещение: ' . $room->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $room)
                <a href="{{ route('rooms.edit', $room->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $room)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данное помещение?"
                    warning="Это действие безвозвратно удалит данное помещение.
                        Это действие также безвозвратно удалит всё оборудование относящееся к данному помещению."
                    :route="route('rooms.destroy', $room->id)"
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
                <th scope="row" class="w-2/12">Номер:</th>
                <td> {{ $room->number }}</td>
            </tr>
            <tr>
                <th scope="row" class="w-2/12">Наименование:</th>
                <td> {{ $room->name }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Тип помещения:</th>
                <td>
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
                class="standard-table__clickable-row"
                @endcan
            >
                <th scope="row" class="w-2/12">Здание:</th>
                <td> {{ $room->building->name }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Этаж:</th>
                <td>
                    {{ $room->floor == 0 ? 'цокольный' : $room->floor }}
                </td>
            </tr>

            <tr
                @if($room->department)
                    @can(['view'], $room->department)
                        onclick="window.location='{{ route('departments.show', $room->department->id) }}';"
                class="standard-table__clickable-row"
                @endcan
                @endif
            >
                <th scope="row" class="w-2/12">
                    Подразделение:
                </th>
                <td>
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

    <div class="content-block">
        <h2 class="h2">
            Оборудование в помещении
        </h2>

        @if(isset($equipment))
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
        @endif

        @can('create', App\Models\Equipment::class)
            <a class="block" href="{{ route('equipment.create', ['room_id' => $room->id]) }}">
                <x-buttons.create>
                    добавить новое оборудование
                </x-buttons.create>
            </a>
        @endcan

        @if(!isset($equipment))
            <div class="block">
                <p>
                    У вас недостаточно прав для просмотра информации об оборудовании в данном
                    помещении.
                </p>
                <p class="mt-2">
                    Вы можете просматривать оборудование только вашего подразделения
                    и его дочерних подразделений если такие имеются.
                </p>
            </div>
        @else
            @if($equipment->count() === 0)
                <p>
                    Оборудования в данном помещении не найдено
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

                        <th scope="col" class="w-2/12 hidden lg:table-cell">
                            <a href="{{ route('equipment.index', ['sort' => 'not_in_operation', 'direction' => 'asc']) }}">
                                Статус текущей эксплуатации
                            </a>
                        </th>

                        <th scope="col" class="w-2/12 hidden lg:table-cell">
                            <a href="{{ route('equipment.index', ['sort' => 'decommissioned', 'direction' => 'asc']) }}">
                                Статус на балансе университета
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

                            <td class="hidden lg:table-cell">
                                {{ $equipment_item->not_in_operation ? 'не в эксплуатации' : 'в эксплуатации' }}
                            </td>

                            <td class="hidden lg:table-cell">
                                {{ $equipment_item->decommissioned ? 'списано' : 'на балансе' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $equipment->links() }}
            @endif
        @endif
    </div>

    <div class="content-block">

        <h2 class="h2">
            Фотографии помещения
        </h2>

        <x-buttons.add-files-with-modal
            description="Выберите одну или несколько фотографий. Допустимые форматы jpeg, png, gif. Размер файла не более 10Мб."
            innerButtonText="Добавить"
            :route="route('rooms.store-images', $room->id)"
        >
            Добавить фотографии
        </x-buttons.add-files-with-modal>

        <div data-te-lightbox-init>
            <div class="gallery">
                @foreach($room->getMedia('images') as $image)
                    <div class="gallery__item">
                        <div class="gallery__picture">
                            <x-buttons.delete-picture-with-modal
                                class="gallery__delete-picture-button"
                                :imageIndex="$loop->index"
                                :route="route('rooms.destroy-image', ['room' => $room->id, 'image_index' => $loop->index])"
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
                <td> {{ $room->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение основных данных:</th>
                <td> {{ $room->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>


</x-app-layout>
