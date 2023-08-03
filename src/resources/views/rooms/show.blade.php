<x-app-layout :title="'Помещение: ' . $room->name">

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
                @case('$room-updated')
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
                    {{ 'Помещение: ' . $room->name }}
                </h1>

                @canany(['update', 'delete'], $room)
                    <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('rooms.edit', $room->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        <x-button-delete-with-modal
                            question="Вы уверены, что хотите удалить данное помещение?"
                            warning="Это действие безвозвратно удалит данное помещение.
                        Это действие также безвозвратно удалит всё оборудование относящееся к данному помещению."
                            :route="route('rooms.destroy', $room->id)"
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
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Номер:</th>
                                            <td class=" px-6 py-4"> {{ $room->number }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Наименование:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $room->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип помещения:</th>
                                            <td class=" px-6 py-4">
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
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endcan
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Здание:
                                            </th>
                                            <td class=" px-6 py-4"> {{ $room->building->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Этаж:
                                            </th>
                                            <td class=" px-6 py-4">
                                                {{ $room->floor == 0 ? 'цокольный' : $room->floor }}
                                            </td>
                                        </tr>

                                        <tr
                                            @if($room->department)
                                                @can(['view'], $room->department)
                                                    onclick="window.location='{{ route('departments.show', $room->department->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                                    hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endcan
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endif
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Подразделение:
                                            </th>
                                            <td class=" px-6 py-4">
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
                                        Оборудование в помещении
                                    </h2>

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
                                                 <a href="{{ route('equipment.create', ['room_id' => $room->id]) }}">
                                                     <x-button-create>
                                                        добавить новое оборудование
                                                     </x-button-create>
                                                 </a>
                                            </span>
                                        </div>
                                    @endcan

                                    @if(!isset($equipment))
                                        <p class="mt-5">
                                            У вас нет прав для просмотра информации об оборудовании в данном
                                            помещении.
                                        </p>
                                    @else
                                        @if($equipment->count() === 0)
                                            <p class="mt-5">
                                                Оборудования в данном помещении не найдено
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
                                                           href="{{ route('equipment.index', ['sort' => 'not_in_operation', 'direction' => 'asc']) }}"
                                                        >
                                                            Статус текущей эксплуатации
                                                        </a>
                                                    </th>

                                                    <th scope="col" class="w-2/12 px-6 py-4 hidden md:table-cell">
                                                        <a class="d-block"
                                                           href="{{ route('equipment.index', ['sort' => 'decommissioned', 'direction' => 'asc']) }}"
                                                        >
                                                            Статус на балансе университета
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

                                                        <td class="px-6 py-4 max-w-250">
                                                            {{ $equipment_item->not_in_operation ? 'не в эксплуатации' : 'в эксплуатации' }}
                                                        </td>

                                                        <td class="px-6 py-4 max-w-250">
                                                            {{ $equipment_item->decommissioned ? 'списано' : 'на балансе' }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                            <div class="mt-3">
                                                {{ $equipment->links() }}
                                            </div>
                                        @endif
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
                                    Фотографии помещения
                                </h2>

                                <x-button-add-files-with-modal
                                    description="Выберите одну или несколько фотографий. Допустимые форматы jpeg, png, gif. Размер файла не более 10Мб."
                                    innerButtonText="Добавить"
                                    :route="route('rooms.store-images', $room->id)"
                                    class=""
                                >
                                    Добавить фотографии
                                </x-button-add-files-with-modal>

                                <div data-te-lightbox-init>
                                    <div class="-m-1 flex flex-wrap  justify-start">
                                        @foreach($room->getMedia('images') as $image)
                                            <div class="flex md:w-1/3 flex-wrap w-full">
                                                <div class="w-full p-1 md:p-2 flex flex-col items-center ">
                                                    <x-button-delete-picture-with-modal
                                                        class="self-end relative top-4"
                                                        :imageIndex="$loop->index"
                                                        :route="route('rooms.destroy-image', ['room' => $room->id, 'image_index' => $loop->index])"
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
                                        <td class=" px-6 py-4"> {{ $room->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение основных
                                            данных:
                                        </th>
                                        <td class=" px-6 py-4"> {{ $room->updated_at }}</td>
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
