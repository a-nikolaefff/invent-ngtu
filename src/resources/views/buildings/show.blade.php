<x-app-layout :centered="true" :title="'Здание: ' . $building->name">

    @if (session('status') === 'department-updated')
        <x-alert type="success">
            Данные успешно изменены
        </x-alert>
    @endif

    @switch(session('status'))
        @case('$building-updated')
            <x-alert type="success" class="mb-4">
                Данные успешно изменены
            </x-alert>
            @break

        @case('images-stored')
            <x-alert type="success" class="mb-4">
                Фотографии успешно загружены
            </x-alert>
            @break

        @case('image-deleted')
            <x-alert type="success" class="mb-4">
                Фотография удалена
            </x-alert>
            @break
    @endswitch

    <div class="page-header">
        <h1 class="h1">
            {{ 'Здание: ' . $building->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $building)
                <a href="{{ route('buildings.edit', $building->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $building)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данное здание?"
                    warning="Это действие безвозвратно удалит данное подразделения.
                        Это действие также безвозвратно удалит все помещения относящиеся к данному зданию."
                    :route="route('buildings.destroy', $building->id)"
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
                <th scope="row" class="w-2/12">Наименование:</th>
                <td> {{ $building->name }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Адрес:</th>
                <td> {{ $building->address }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Количество этажей:</th>
                <td> {{ $building->floor_amount }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Тип здания:</th>
                <td>
                    @if($building->type)
                        {{ $building->type->name }}
                    @else
                        не задан
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Помещения
        </h2>

        <x-option-selector
            class="w-full md:w-8/12 lg:w-4/12"
            id="optionSelector1"
            label="Тип помещения"
            :options="$roomTypes"
            parameter="room_type_id"
            passing-property='id'
            displaying-property='name'
            all-options-selection='любой тип'
            not-specified-option-selection='не задан'
        />

        <div class="w-full md:w-8/12 lg:w-4/12">
            <x-forms.input-label value="Этаж" class="mb-1"/>
            <div id="optionSelector2" data-value="floor">
                <select data-te-select-init>
                    <option
                        value="allOptionsSelection">
                        любой
                    </option>
                    @for ($i = 0; $i <= $floorAmount; $i++)
                        <option
                            value="{{ $i }}">
                            {{ $i === 0 ? 'цокольный' : $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        @can('create', App\Models\Room::class)
            <a class="block" href="{{ route('rooms.create', ['building_id' => $building->id]) }}">
                <x-buttons.create>
                    добавить новое помещение
                </x-buttons.create>
            </a>
        @endcan

        @if($rooms->count() === 0)
            <p class="block">
                Помещений в данном здании не найдено
            </p>
        @else
            <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
                <thead>
                <tr>
                    <th scope="col" class="w-1/12">
                        <a href="{{ route('rooms.index', ['sort' => 'number', 'direction' => 'asc']) }}">
                            Номер
                        </a>
                    </th>

                    <th scope="col" class="w-4/12">
                        <a href="{{ route('rooms.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                            Наименование
                        </a>
                    </th>

                    <th scope="col" class="w-2/12 hidden md:table-cell">
                        <a href="{{ route('rooms.index', ['sort' => 'room_type_name', 'direction' => 'asc']) }}">
                            Тип помещения
                        </a>
                    </th>

                    <th scope="col" class="w-3/12 hidden md:table-cell">
                        <a href="{{ route('rooms.index', ['sort' => 'department_name', 'direction' => 'asc']) }}">
                            Подразделение
                        </a>
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach($rooms as $room)
                    <tr
                        onclick="window.location='{{ route('rooms.show', $room->id) }}';">

                        <td>{{ $room->number }}</td>

                        <td>{{ $room->name }}</td>

                        <td class="hidden md:table-cell">
                            @if($room->type)
                                {{ $room->type->name }}
                            @else
                                не задан
                            @endif
                        </td>

                        <td class="hidden md:table-cell">
                            @if($room->department)
                                {{ $room->department->name }}
                            @else
                                не задан
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $rooms->links() }}
        @endif
    </div>

    <div class="content-block">
        <h2 class="h2">
            Фотографии здания
        </h2>

        <x-buttons.add-files-with-modal
            description="Выберите одну или несколько фотографий. Допустимые форматы jpeg, png, gif. Размер файла не более 10Мб."
            innerButtonText="Добавить"
            :route="route('buildings.store-images', $building->id)"
        >
            Добавить фотографии
        </x-buttons.add-files-with-modal>

        <div data-te-lightbox-init>
            <div class="gallery">
                @foreach($building->getMedia('images') as $image)
                    <div class="gallery__item">
                        <div class="gallery__picture">
                            <x-buttons.delete-picture-with-modal
                                class="gallery__delete-picture-button"
                                :imageIndex="$loop->index"
                                :route="route('buildings.destroy-image', ['building' => $building->id, 'image_index' => $loop->index])"
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
                <td> {{ $building->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение основных данных:</th>
                <td> {{ $building->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
