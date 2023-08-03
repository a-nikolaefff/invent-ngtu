<x-app-layout :title="'Здание: ' . $building->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if ($errors)
                @foreach($errors->all() as $error)
                    <x-alert type="danger" class="mb-4">
                        {{ $error }}
                    </x-alert>
                @endforeach
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

            <div class="sm:px-8">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Здание: ' . $building->name }}
                </h1>

                @canany(['update', 'delete'], $building)
                    <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('buildings.edit', $building->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        <x-button-delete-with-modal
                            question="Вы уверены, что хотите удалить данное здание?"
                            warning="Это действие безвозвратно удалит данное подразделения.
                        Это действие также безвозвратно удалит все помещения относящиеся к данному зданию."
                            :route="route('buildings.destroy', $building->id)"
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
                                            <td class=" px-6 py-4"> {{ $building->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Адрес:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $building->address }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Количество этажей:</th>
                                            <td class=" px-6 py-4"> {{ $building->floor_amount }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип здания:</th>
                                            <td class=" px-6 py-4">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">

                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Помещения
                                    </h2>

                                    <div class="w-full md:w-8/12 lg:w-4/12">
                                        <x-input-label value="Тип помещения" class="mb-1"/>
                                        <x-option-selector
                                            id="optionSelector1"
                                            :url="route('rooms.index')"
                                            parameter-name="room_type_id"
                                            :options="$roomTypes"
                                            passing-property='id'
                                            displaying-property='name'
                                            all-options-selector='любой тип'
                                            not-specified-option-selector='не задан'
                                        ></x-option-selector>
                                    </div>

                                    <div class="w-full md:w-8/12 lg:w-4/12">
                                        <x-input-label value="Этаж" class="mb-1"/>
                                        <div id="optionSelector3" data-value="floor">
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
                                        <div class="my-3">
                                            <span class="mr-2">
                                                 <a href="{{ route('rooms.create', ['building_id' => $building->id]) }}">
                                                     <x-button-create>
                                                        добавить новое помещение
                                                     </x-button-create>
                                                 </a>
                                            </span>
                                        </div>
                                    @endcan

                                    @if($rooms->count() === 0)
                                        <p class="mt-5">
                                            Помещений в данном здании не найдено
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
                                                       href="{{ route('rooms.index', ['sort' => 'number', 'direction' => 'asc']) }}"
                                                    >
                                                        Номер
                                                    </a>
                                                </th>

                                                <th scope="col" class="w-4/12 px-6 py-4">
                                                    <a class="d-block"
                                                       href="{{ route('rooms.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                                    >
                                                        Наименование
                                                    </a>
                                                </th>

                                                <th scope="col" class="w-2/12 px-6 py-4 hidden md:table-cell">
                                                    <a class="d-block"
                                                       href="{{ route('rooms.index', ['sort' => 'room_type_name', 'direction' => 'asc']) }}"
                                                    >
                                                        Тип помещения
                                                    </a>
                                                </th>

                                                <th scope="col" class="w-3/12 px-6 py-4 hidden md:table-cell">
                                                    <a class="d-block"
                                                       href="{{ route('rooms.index', ['sort' => 'department_name', 'direction' => 'asc']) }}"
                                                    >
                                                        Подразделение
                                                    </a>
                                                </th>
                                            </tr>

                                            </thead>

                                            <tbody>
                                            @foreach($rooms as $room)
                                                <tr
                                                    onclick="window.location='{{ route('rooms.show', $room->id) }}';"
                                                    class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                                                    <td class="px-6 py-4 max-w-250">{{ $room->number }}</td>

                                                    <td class="px-6 py-4 max-w-250">{{ $room->name }}</td>

                                                    <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                                        @if($room->type)
                                                            {{ $room->type->name }}
                                                        @else
                                                            не задан
                                                        @endif
                                                    </td>

                                                    <td class="px-6 py-4 max-w-250 hidden md:table-cell">
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

                                        <div class="mt-3">
                                            {{ $rooms->links() }}
                                        </div>
                                    @endif


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
                            <div class="">
                                <h2 class="mb-2 text-lg font-medium text-gray-900">
                                    Фотографии здания
                                </h2>

                                <x-button-add-files-with-modal
                                    description="Выберите одну или несколько фотографий. Допустимые форматы jpeg, png, gif. Размер файла не более 10Мб."
                                    innerButtonText="Добавить"
                                    :route="route('buildings.store-images', $building->id)"
                                    class=""
                                >
                                    Добавить фотографии
                                </x-button-add-files-with-modal>

                                <div data-te-lightbox-init>
                                    <div class="-m-1 flex flex-wrap  justify-start">
                                        @foreach($building->getMedia('images') as $image)
                                            <div class="flex md:w-1/3 flex-wrap w-full">
                                                <div class="w-full p-1 md:p-2 flex flex-col items-center ">
                                                    <x-button-delete-picture-with-modal
                                                        class="self-end relative top-4"
                                                        :imageIndex="$loop->index"
                                                        :route="route('buildings.destroy-image', ['building' => $building->id, 'image_index' => $loop->index])"
                                                    />
                                                    <img
                                                        src="{{ $image->getUrl('preview') }}"
                                                        data-te-img="{{ $image->getUrl() }}"
                                                        alt="{{ 'Добавлена ' . $image->getCustomProperty('datetime') . ' пользователем ' . $image->getCustomProperty('user_name') .' (id ' . $image->getCustomProperty('user_id') . ')'}} "
                                                        class="w-full clickable rounded shadow-sm data-[te-lightbox-disabled]:cursor-auto"/>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
                                        <th scope="row" class="w-2/12 px-2 py-4 text-right">Создано:</th>
                                        <td class=" px-6 py-4"> {{ $building->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение основных
                                            данных:
                                        </th>
                                        <td class=" px-6 py-4"> {{ $building->updated_at }}</td>
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
