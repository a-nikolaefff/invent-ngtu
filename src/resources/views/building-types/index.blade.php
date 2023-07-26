<x-admin-layout title="Типы зданий">

    @if (session('status') === 'building-type-stored')
        <x-alert type="success" class="mb-4">
            Новый тип здания успешно добавлен
        </x-alert>
    @endif

        @if (session('status') === 'building-type-deleted')
            <x-alert type="success" class="mb-4">
                Тип здания удален
            </x-alert>
        @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Типы зданий
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                <div class="mb-3">
                        <span class="mr-2">
                            <a href="{{ route('building-types.create') }}">
                                <x-button-create>
                                    Создать новый тип
                                </x-button-create>
                            </a>
                        </span>
                </div>

                    @if($buildingTypes->count() === 0)
                        <p class="h5 ">
                            Результаты не найдены
                        </p>
                    @else

                    <table class="table-fixed min-w-full text-left text-sm font-light mx-auto
                    max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden"
                           id="sortableTable">
                        <thead class="border-b font-medium dark:border-neutral-500">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('building-types.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                >
                                    Наименование
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($buildingTypes as $buildingType)
                        <tr
                            onclick="window.location='{{ route('building-types.show', $buildingType->id) }}';"
                            class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">
                            <td class="whitespace-nowrap px-6 py-4 truncate max-w-250">{{ $buildingType->name }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $buildingTypes->links() }}
                    </div>

                    @endif

            </div>
        </div>
    </div>

</x-admin-layout>