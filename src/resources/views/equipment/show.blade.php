<x-app-layout :title="'Оборудование:  инв. № ' . $equipment->number . ', ' . $equipment->name">

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
                @case('equipment-updated')
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
                    {{ 'Оборудование:  инв. № ' . $equipment->number . ', ' . $equipment->name }}
                </h1>

                @canany(['update', 'delete'], $equipment)
                    <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('equipment.edit', $equipment->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        <x-button-delete-with-modal
                            question="Вы уверены, что хотите удалить данное оборудование?"
                            warning="Это действие безвозвратно удалит данное оборудование.
                        Это действие также безвозвратно удалит все ремонты и заявки на ремонт
                         относящиеся к данному оборудованию."
                            :route="route('equipment.destroy', $equipment->id)"
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
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Инвентарный номер:</th>
                                            <td class="px-6 py-4"> {{ $equipment->number }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип оборудования:</th>
                                            <td class="px-6 py-4">
                                                @if($equipment->type)
                                                    {{ $equipment->type->name }}
                                                @else
                                                    не задан
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Наименование:</th>
                                            <td class="px-6 py-4"> {{ $equipment->name }}</td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Описание:</th>
                                            <td class="px-6 py-4"> {{ $equipment->description }}</td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата приобретения:</th>
                                            <td class="px-6 py-4">
                                                @if(isset($equipment->acquisition_date))
                                                    {{ $equipment->acquisition_date->format('d.m.Y') }}
                                                @else
                                                    не задана
                                                @endif
                                            </td>
                                        </tr>

                                        <tr
                                            onclick="window.location='{{ route('rooms.show', $equipment->room->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"

                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Месторасположение:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $equipment->room->number . ' (' . $equipment->room->building->name . ')' }}
                                            </td>
                                        </tr>

                                        <tr
                                            @if($equipment->room->department)
                                                @can(['view'], $equipment->room->department)
                                                    onclick="window.location='{{ route('departments.show', $equipment->room->department->id) }}';"
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
                                                Подразделение помещения:
                                            </th>
                                            <td class="px-6 py-4">
                                                @if($equipment->room->department)
                                                    {{ $equipment->room->department->name }}
                                                @else
                                                    нет
                                                @endif
                                            </td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Статус текущей эксплуатации:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $equipment->not_in_operation ? 'не в эксплуатации' : 'в эксплуатации' }}
                                            </td>
                                        </tr>

                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Статус на балансе университета:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $equipment->decommissioned ? 'списано' : 'на балансе' }}
                                            </td>
                                        </tr>

                                        @if(isset($equipment->decommissioning_date))
                                            <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата списания:</th>
                                                <td class="px-6 py-4">
                                                    {{ $equipment->decommissioning_date->format('d.m.Y') }}
                                                </td>
                                            </tr>
                                        @endif

                                        @if(isset($equipment->decommissioning_reason))
                                            <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Причина списания:
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $equipment->decommissioning_reason }}
                                                </td>
                                            </tr>
                                        @endif

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
                                        Ремонты данного оборудования
                                    </h2>

                                    <div class="flex mb-2">
                                        <div class="w-full md:w-8/12 lg:w-4/12">
                                            <x-input-label value="Тип ремонта" class="mb-1"/>
                                            <x-option-selector
                                                id="optionSelector1"
                                                :url="route('equipment.index')"
                                                parameter-name="repair_type_id"
                                                :options="$repairTypes"
                                                passing-property='id'
                                                displaying-property='name'
                                                all-options-selector='любой'
                                                not-specified-option-selector='не задан'
                                            ></x-option-selector>
                                        </div>
                                        <div class="ml-3 w-full md:w-8/12 lg:w-4/12">
                                            <x-input-label value="Статус ремонта" class="mb-1"/>
                                            <x-option-selector
                                                id="optionSelector2"
                                                :url="route('equipment.index')"
                                                parameter-name="repair_status_id"
                                                :options="$repairStatuses"
                                                passing-property='id'
                                                displaying-property='name'
                                                all-options-selector='любой'
                                            ></x-option-selector>
                                        </div>
                                    </div>

                                        <div class="my-3">
                                            @can('create', App\Models\Repair::class)
                                            <a href="{{ route('repairs.create', ['equipment_id' => $equipment->id]) }}">
                                                <x-button-create class="mr-2 mb-3">
                                                    добавить новый ремонт
                                                </x-button-create>
                                            </a>
                                            @endcan
                                            @can('create', App\Models\RepairApplication::class)
                                                <a href="{{ route('repair-applications.create', ['equipment_id' => $equipment->id]) }}">
                                                    <x-button-create>
                                                        Создать заявку на ремонт
                                                    </x-button-create>
                                                </a>
                                            @endcan
                                        </div>

                                    @if($repairs->count() === 0)
                                        <p class="mt-5">
                                            Ремонтов данного оборудования не найдено
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
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <h2 class="mb-2 text-lg font-medium text-gray-900">
                                    Фотографии оборудования
                                </h2>

                                <x-button-add-files-with-modal
                                    description="Выберите одну или несколько фотографий. Допустимые форматы jpeg, png, gif. Размер файла не более 10Мб."
                                    innerButtonText="Добавить"
                                    :route="route('equipment.store-images', $equipment->id)"
                                >
                                    Добавить фотографии
                                </x-button-add-files-with-modal>

                                <div data-te-lightbox-init>
                                    <div class="-m-1 flex flex-wrap justify-start mt-2">
                                        @foreach($equipment->getMedia('images') as $image)
                                            <div class="flex md:w-1/3 flex-wrap w-full">
                                                <div class="w-full p-1 md:p-2 flex flex-col items-center relative">
                                                    <x-button-delete-picture-with-modal
                                                        class="self-end absolute -top-1"
                                                        :imageIndex="$loop->index"
                                                        :route="route('equipment.destroy-image', ['equipment' => $equipment->id, 'image_index' => $loop->index])"
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
                            <div class="">
                                <h2 class="mb-2 text-lg font-medium text-gray-900">
                                    Хронологические данные
                                </h2>

                                <table class="min-w-full text-left text-sm font-light">
                                    <tbody>

                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="w-2/12 px-2 py-4 text-right">Создано:</th>
                                        <td class="px-6 py-4"> {{ $equipment->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение основных
                                            данных:
                                        </th>
                                        <td class="px-6 py-4"> {{ $equipment->updated_at }}</td>
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
