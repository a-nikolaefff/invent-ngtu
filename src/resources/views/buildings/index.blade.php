<x-app-layout title="Здания">

    @if (session('status') === 'building-stored')
        <x-alert type="success" class="mb-4">
            Новое здание успешно добавлено
        </x-alert>
    @endif

    @if (session('status') === 'building-deleted')
        <x-alert type="success" class="mb-4">
            Здание удалено
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Здания
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                    <div class="flex mb-3">
                        <div class="w-full md:w-8/12 lg:w-1/2">
                            <x-search-form
                                :value="request()->search"
                                placeholder="Поиск по наименованию"
                            ></x-search-form>
                        </div>
                        <div></div>
                    </div>

                    <div class="flex mb-2">
                        <div class="w-full md:w-8/12 lg:w-4/12">
                            <x-input-label value="Тип здания" class="mb-1" />
                            <x-option-selector
                                id="optionSelector1"
                                :url="route('buildings.index')"
                                parameter-name="building_type_id"
                                :options="$buildingTypes"
                                passing-property='id'
                                displaying-property='name'
                                all-options-selector='любой тип'
                                not-specified-option-selector='не задан'
                            ></x-option-selector>
                        </div>
                        <div></div>
                    </div>

                @can('create', App\Models\building::class)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('buildings.create') }}">
                                <x-button-create>
                                    добавить новое здание
                                </x-button-create>
                            </a>
                        </span>
                    </div>
                @endcan

                    @if($buildings->count() === 0)
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
                            <th scope="col" class="w-7/12 px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('buildings.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                >
                                    Наименование
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('buildings.index', ['sort' => 'floor_amount', 'direction' => 'asc']) }}"
                                >
                                    Количество этажей
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('buildings.index', ['sort' => 'building_type_name', 'direction' => 'asc']) }}"
                                >
                                    Тип здания
                                </a>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($buildings as $building)
                        <tr
                            onclick="window.location='{{ route('buildings.show', $building->id) }}';"
                            class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                            <td class="px-6 py-4 max-w-250">{{ $building->name }}</td>

                            <td class="px-6 py-4 max-w-250">{{ $building->floor_amount }}</td>

                            <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                @if($building->type)
                                    {{ $building->type->name }}
                                @else
                                    не задан
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $buildings->links() }}
                    </div>

                    @endif
            </div>
        </div>
    </div>

</x-app-layout>
