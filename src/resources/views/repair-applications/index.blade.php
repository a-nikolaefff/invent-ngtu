@php
    $canViewUserInformation = \Illuminate\Support\Facades\Auth::user()
    ->can('viewUserInformation', App\Models\RepairApplication::class);
@endphp

<x-app-layout title="Заявки на ремонт оборудования">

    @if (session('status') === 'repair-application-stored')
        <x-alert type="success" class="mb-4">
            Заявка отправлена на рассмотрение. Если необходимо вы можете приложить к заявке фотографии на странице
            заявки.
        </x-alert>
    @endif

    @if (session('status') === 'repair-application-deleted')
        <x-alert type="success" class="mb-4">
            Заявка удалена
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        @if($canViewUserInformation)
            Заявки на ремонт оборудования
        @else
            Мои заявки на ремонт оборудования
        @endif
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                <div class="flex mb-3">
                    <div class="w-full md:w-8/12 lg:w-1/2">
                        <x-search-form
                            :value="request()->search"
                            placeholder="Поиск по номеру или описанию заявки, инв. номеру или наим. оборудования"
                        ></x-search-form>
                    </div>
                    <div></div>
                </div>


                <div class="w-full md:w-8/12 lg:w-4/12">
                    <x-input-label value="Статус заявки" class="mb-1"/>
                    <x-option-selector
                        id="optionSelector1"
                        :url="route('repairs.index')"
                        parameter-name="repair_application_status_id"
                        :options="$applicationStatuses"
                        passing-property='id'
                        displaying-property='name'
                        all-options-selector='любой'
                    ></x-option-selector>
                </div>


                @can('create', App\Models\RepairApplication::class)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('repair-applications.create') }}">
                                <x-button-create>
                                    Создать новую заявку
                                </x-button-create>
                            </a>
                        </span>
                    </div>
                @endcan

                @if($repairApplications->count() === 0)
                    <p class="h5">
                        Заявки не найдены
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
                                   href="{{ route('repair-applications.index', ['sort' => 'id', 'direction' => 'asc']) }}"
                                >
                                    Номер заявки
                                </a>
                            </th>

                            <th scope="col" class="w-4/12 px-6 py-4 hidden sm:table-cell">
                                <a class="d-block"
                                   href="{{ route('repair-applications.index', ['sort' => 'short_description', 'direction' => 'asc']) }}"
                                >
                                    Краткое описание заявки
                                </a>
                            </th>

                            <th scope="col" class="w-3/12 px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('repair-applications.index', ['sort' => 'equipment_name', 'direction' => 'asc']) }}"
                                >
                                    Неисправное оборудование
                                </a>
                            </th>

                            <th scope="col" class="w-1/12 px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('repair-applications.index', ['sort' => 'application_date', 'direction' => 'asc']) }}"
                                >
                                    Дата подачи
                                </a>
                            </th>

                            <th scope="col" class="w-1/12 px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('repair-applications.index', ['sort' => 'response_date', 'direction' => 'asc']) }}"
                                >
                                    Дата ответа
                                </a>
                            </th>

                            @if($canViewUserInformation)
                                <th scope="col" class="w-1/12 px-6 py-4 hidden md:table-cell">
                                    <a class="d-block"
                                       href="{{ route('repair-applications.index', ['sort' => 'user_name', 'direction' => 'asc']) }}"
                                    >
                                        Пользователь
                                    </a>
                                </th>
                            @endif


                            <th scope="col" class="w-1/12 px-6 py-4 hidden md:table-cell">
                                <a class="d-block"
                                   href="{{ route('repair-applications.index', ['sort' => 'repair_application_status_id', 'direction' => 'asc']) }}"
                                >
                                    Статус заявки
                                </a>
                            </th>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($repairApplications as $application)
                            <tr
                                onclick="window.location='{{ route('repair-applications.show', $application->id) }}';"
                                class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                                <td class="px-6 py-4 max-w-250">{{ $application->id }}</td>

                                <td class="px-6 py-4 max-w-250 hidden sm:table-cell">{{ $application->short_description }}</td>

                                <td class="px-6 py-4 max-w-250">
                                    {{ 'инв. № ' . $application->equipment->number . ', ' . $application->equipment->name }}
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden lg:table-cell">
                                    @if($application->application_date)
                                        {{ $application->application_date->format('d.m.Y') }}
                                    @else
                                        не задана
                                    @endif
                                </td>

                                <td class="px-6 py-4 max-w-250 hidden lg:table-cell">
                                    @if($application->response_date)
                                        {{ $application->response_date->format('d.m.Y') }}
                                    @else
                                        не задана
                                    @endif
                                </td>

                                @if($canViewUserInformation)
                                    <td class="px-6 py-4 max-w-250 hidden md:table-cell">
                                        {{ $application->user->name }}
                                    </td>
                                @endif

                                <td class="px-6 py-4 max-w-250 font-medium hidden md:table-cell
                                                @switch($application->status->name )
                                                @case(App\Enums\RepairApplicationStatusEnum::Pending->value)
                                                    text-blue-700
                                                @break
                                                @case(App\Enums\RepairApplicationStatusEnum::Rejected->value)
                                                    text-red-700
                                                @break
                                                @case(App\Enums\RepairApplicationStatusEnum::Approved->value)
                                                    text-green-600
                                                @endswitch
                                                ">
                                    {{ $application->status->name }}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $repairApplications->links() }}
                    </div>

                @endif
            </div>
        </div>
    </div>

</x-app-layout>
