@php
    $canManageImages = \Illuminate\Support\Facades\Auth::user()->can('manageImages', $repair);
@endphp

<x-layouts.app :centered="true" :title="'Ремонт: ' . $repair->name">

    @if ($errors)
        @foreach($errors->all() as $error)
            <x-alert type="danger">
                {{ $error }}
            </x-alert>
        @endforeach
    @endif

    @switch(session('status'))
        @case('repair-stored')
            <x-alert type="success">
                Новый ремонт успешно добавлен
            </x-alert>
            @break

        @case('repair-updated')
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
            {{ 'Ремонт: ' . $repair->short_description }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $repair)
                <a href="{{ route('repairs.edit', $repair->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $repair)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данный ремонт?"
                    warning="Это действие безвозвратно удалит данный ремонт."
                    :route="route('repairs.destroy', $repair->id)"
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
                onclick="window.location='{{ route('equipment.show', $repair->equipment->id) }}';"
                class="standard-table__clickable-row">
                <th scope="row" class="w-2/12">Ремонтируемое оборудование:</th>
                <td>{{ $repair->equipment->name . ', инв. № ' . $repair->equipment->number }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Краткое описание ремонта:</th>
                <td> {{ $repair->short_description }}</td>
            </tr>

            <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                <th scope="row" class="w-2/12">Полное описание ремонта:</th>
                <td> {{ $repair->full_description }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Тип:</th>
                <td>
                    @if($repair->type)
                        {{ $repair->type->name }}
                    @else
                        не задан
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Cтатус:</th>
                <td>{{ $repair->status->name }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Дата начала</th>
                <td>
                    @if($repair->start_date)
                        {{ $repair->start_date->format('d.m.Y') }}
                    @else
                        не задана
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Дата окончания</th>
                <td>
                    @if($repair->end_date)
                        {{ $repair->end_date->format('d.m.Y') }}
                    @else
                        не задана
                    @endif
                </td>
            </tr>

            </tbody>
        </table>
    </div>


    @if($repair->getMedia('before')->count() > 0 || $canManageImages)
        <div class="content-block">

            <h2 class="h2">
                Фотографии до выполнения ремонта
            </h2>

            @if($canManageImages)
                <x-buttons.add-files-with-modal
                    description="Выберите одну или несколько фотографий. Допустимые форматы jpg, png, gif. Ширина и высота изображения не более 4000 пикселей. Размер каждого файла не более 10Мб."
                    innerButtonText="Добавить"
                    :route="route('repairs.store-before-images', $repair->id)"
                    modalId="uploadBeforeImages"
                >
                    Добавить фотографии
                </x-buttons.add-files-with-modal>
            @endif

            <div data-te-lightbox-init>
                <div class="gallery">
                    @foreach($repair->getMedia('before') as $image)
                        <div class="gallery__item">
                            <div class="gallery__picture">
                                @if($canManageImages)
                                    <x-buttons.delete-picture-with-modal
                                        class="gallery__delete-picture-button"
                                        :imageIndex="$loop->index"
                                        modalId="deleteBeforeImages"
                                        :route="route('repairs.destroy-before-image', ['repair' => $repair->id, 'image_index' => $loop->index])"
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

    @if($repair->getMedia('after')->count() > 0 || $canManageImages)
        <div class="content-block">

            <h2 class="h2">
                Фотографии после выполнения ремонта
            </h2>

            @if($canManageImages)
                <x-buttons.add-files-with-modal
                    description="Выберите одну или несколько фотографий. Допустимые форматы jpg, png, gif. Ширина и высота изображения не более 4000 пикселей. Размер каждого файла не более 10Мб."
                    innerButtonText="Добавить"
                    :route="route('repairs.store-after-images', $repair->id)"
                    modalId="uploadAfterImages"
                >
                    Добавить фотографии
                </x-buttons.add-files-with-modal>
            @endif

            <div data-te-lightbox-init>
                <div class="gallery">
                    @foreach($repair->getMedia('after') as $image)
                        <div class="gallery__item">
                            <div class="gallery__picture">
                                @if($canManageImages)
                                    <x-buttons.delete-picture-with-modal
                                        class="gallery__delete-picture-button"
                                        :imageIndex="$loop->index"
                                        modalId="deleteAfterImages"
                                        :route="route('repairs.destroy-after-image', ['repair' => $repair->id, 'image_index' => $loop->index])"
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

    <div class="content-block">

        <h2 class="h2">
            Хронологические данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>

            <tr>
                <th scope="row" class="w-2/12">Создано:</th>
                <td> {{ $repair->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение основных данных:</th>
                <td> {{ $repair->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</x-layouts.app>
