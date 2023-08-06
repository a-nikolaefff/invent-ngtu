@php
    $canViewUserInformation = \Illuminate\Support\Facades\Auth::user()
    ->can('viewUserInformation', App\Models\RepairApplication::class);
@endphp

<x-app-layout title="Заявки на ремонт оборудования">

    @if (session('status') === 'repair-application-stored')
        <x-alert type="success">
            Заявка отправлена на рассмотрение.
            Если необходимо вы можете приложить к заявке фотографии на странице заявки.
        </x-alert>
    @endif

    @if (session('status') === 'repair-application-deleted')
        <x-alert type="success">
            Заявка удалена
        </x-alert>
    @endif

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            @if($canViewUserInformation)
                Заявки на ремонт оборудования
            @else
                Мои заявки на ремонт оборудования
            @endif
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по номеру или описанию заявки, инв. номеру или наим. оборудования"
    ></x-search-form>

    <x-option-selector
        class="w-full md:w-8/12 lg:w-4/12"
        id="optionSelector1"
        label="Статус заявки"
        :options="$applicationStatuses"
        parameter="repair_application_status_id"
        passing-property='id'
        displaying-property='name'
        all-options-selection='любой'
    />

    @can('create', App\Models\RepairApplication::class)
        <a class="block" href="{{ route('repair-applications.create') }}">
            <x-buttons.create>
                Создать новую заявку
            </x-buttons.create>
        </a>
    @endcan

    @if($repairApplications->count() === 0)
        <p class="block">
            Заявки не найдены
        </p>
    @else
        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col" class="w-1/12">
                    <a href="{{ route('repair-applications.index', ['sort' => 'id', 'direction' => 'asc']) }}">
                        Номер заявки
                    </a>
                </th>

                <th scope="col" class="w-4/12 hidden sm:table-cell">
                    <a href="{{ route('repair-applications.index', ['sort' => 'short_description', 'direction' => 'asc']) }}">
                        Краткое описание заявки
                    </a>
                </th>

                <th scope="col" class="w-3/12">
                    <a href="{{ route('repair-applications.index', ['sort' => 'equipment_name', 'direction' => 'asc']) }}">
                        Неисправное оборудование
                    </a>
                </th>

                <th scope="col" class="w-1/12 hidden lg:table-cell">
                    <a href="{{ route('repair-applications.index', ['sort' => 'application_date', 'direction' => 'asc']) }}">
                        Дата подачи
                    </a>
                </th>

                <th scope="col" class="w-1/12 hidden lg:table-cell">
                    <a href="{{ route('repair-applications.index', ['sort' => 'response_date', 'direction' => 'asc']) }}">
                        Дата ответа
                    </a>
                </th>

                @if($canViewUserInformation)
                    <th scope="col" class="w-1/12 hidden md:table-cell">
                        <a href="{{ route('repair-applications.index', ['sort' => 'user_name', 'direction' => 'asc']) }}">
                            Пользователь
                        </a>
                    </th>
                @endif

                <th scope="col" class="w-1/12 hidden md:table-cell">
                    <a href="{{ route('repair-applications.index', ['sort' => 'repair_application_status_id', 'direction' => 'asc']) }}">
                        Статус заявки
                    </a>
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($repairApplications as $application)
                <tr
                    onclick="window.location='{{ route('repair-applications.show', $application->id) }}';">

                    <td>{{ $application->id }}</td>

                    <td class="hidden sm:table-cell">{{ $application->short_description }}</td>

                    <td>
                        {{ 'инв. № ' . $application->equipment->number . ', ' . $application->equipment->name }}
                    </td>

                    <td class="hidden lg:table-cell">
                        @if($application->application_date)
                            {{ $application->application_date->format('d.m.Y') }}
                        @else
                            не задана
                        @endif
                    </td>

                    <td class="hidden lg:table-cell">
                        @if($application->response_date)
                            {{ $application->response_date->format('d.m.Y') }}
                        @else
                            не задана
                        @endif
                    </td>

                    @if($canViewUserInformation)
                        <td class="hidden md:table-cell">
                            {{ $application->user->name }}
                        </td>
                    @endif

                    <td class="font-medium hidden md:table-cell
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
        {{ $repairApplications->links() }}
    @endif
</x-app-layout>
