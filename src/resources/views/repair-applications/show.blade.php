@php
    $canManageImages = \Illuminate\Support\Facades\Auth::user()
    ->can('manageImages', $repairApplication);

    $canViewUserInformation = \Illuminate\Support\Facades\Auth::user()
    ->can('viewUserInformation', App\Models\RepairApplication::class);
@endphp

<x-app-layout :centered="true" :title="'Заявка на ремонт: ' . $repairApplication->name">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @switch(session('status'))
        @case('repair-application-stored')
            <x-alert type="success">
                Заявка отправлена на рассмотрение. Если необходимо вы можете приложить к заявке фотографии.
            </x-alert>
            @break

        @case('repair-application-updated')
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
            {{ 'Заявка на ремонт: ' . $repairApplication->short_description }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $repairApplication)
                <a href="{{ route('repair-applications.edit', $repairApplication->id) }}">
                    <x-buttons.edit class="mr-2">
                        Ответить на заявку
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $repairApplication)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данную заявку?"
                    warning="Это действие безвозвратно удалит данную заявку."
                    :route="route('repair-applications.destroy', $repairApplication->id)"
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

            <tr
                onclick="window.location='{{ route('equipment.show', $repairApplication->equipment->id) }}';"
                class="standard-table__clickable-row">
                <th scope="row" class="w-2/12">Неисправное оборудование:</th>
                <td>{{ $repairApplication->equipment->name . ', инв. № ' . $repairApplication->equipment->number }}</td>
            </tr>

            @if($canViewUserInformation)
                <tr>
                    <th scope="row" class="w-2/12">Отправитель:</th>
                    <td> {{ $repairApplication->user->name }}</td>
                </tr>
            @endif

            <tr>
                <th scope="row" class="w-2/12">Краткое описание заявки:</th>
                <td> {{ $repairApplication->short_description }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Расширенное описание заявки:</th>
                <td> {{ $repairApplication->full_description }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Дата подачи</th>
                <td>{{ $repairApplication->application_date->format('d.m.Y') }}</td>
            </tr>

            @if($repairApplication->response_date)
                <tr>
                    <th scope="row" class="w-2/12">Дата ответа</th>
                    <td>{{ $repairApplication->response_date->format('d.m.Y') }}</td>
                </tr>
            @endif

            <tr>
                <th scope="row" class="w-2/12">Cтатус:</th>
                <td class="font-medium
                                            @switch($repairApplication->status->name )
                                                @case(App\Enums\RepairApplicationStatusEnum::Pending->value)
                                                    text-blue-700
                                                @break
                                                @case(App\Enums\RepairApplicationStatusEnum::Rejected->value)
                                                    text-red-700
                                                @break
                                                @case(App\Enums\RepairApplicationStatusEnum::Approved->value)
                                                    text-green-600
                                                @endswitch
                                                "
                >
                    {{ $repairApplication->status->name }}
                </td>
            </tr>
            @if($repairApplication->response)
                <tr>
                    <th scope="row" class="w-2/12">Ответ по заявке:</th>
                    <td>{{ $repairApplication->response }}</td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>

    @if($repairApplication->getMedia('images')->count() > 0 || $canManageImages)
        <div class="content-block">

            <h2 class="h2">
                Приложенные фотографии
            </h2>

            @if($canManageImages)
                <x-buttons.add-files-with-modal
                    description="Выберите одну или несколько фотографий. Допустимые форматы jpg, png, gif. Ширина и высота изображения не более 4000 пикселей. Размер каждого файла не более 10Мб."
                    innerButtonText="Добавить"
                    :route="route('repair-applications.store-images', $repairApplication->id)"
                    modalId="uploadBeforeImages"
                >
                    Добавить фотографии
                </x-buttons.add-files-with-modal>
            @endif

            <div data-te-lightbox-init>
                <div class="gallery">
                    @foreach($repairApplication->getMedia('images') as $image)
                        <div class="gallery__item">
                            <div class="gallery__picture">
                                @if($canManageImages)
                                    <x-buttons.delete-picture-with-modal
                                        class="gallery__delete-picture-button"
                                        :imageIndex="$loop->index"
                                        modalId="deleteBeforeImages"
                                        :route="route('repair-applications.destroy-image', ['repairApplication' => $repairApplication->id, 'image_index' => $loop->index])"
                                    />
                                @endif
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
    @endif

</x-app-layout>
