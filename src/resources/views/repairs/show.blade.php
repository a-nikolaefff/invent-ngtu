@php
    $canManageImages = \Illuminate\Support\Facades\Auth::user()->can('update', $repair);
@endphp

<x-app-layout :title="'Ремонт: ' . $repair->name">

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
                @case('repair-updated')
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
                    {{ 'Ремонт: ' . $repair->short_description }}
                </h1>

                @canany(['update', 'delete'], $repair)
                    <div class="my-4">
                        <span class="mr-2">
                            <a href="{{ route('repairs.edit', $repair->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        <x-button-delete-with-modal
                            question="Вы уверены, что хотите удалить данный ремонт?"
                            warning="Это действие безвозвратно удалит данный ремонт."
                            :route="route('repairs.destroy', $repair->id)"
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
                                            onclick="window.location='{{ route('equipment.show', $repair->equipment->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"

                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Ремонтируемое оборудование:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ 'инв. № ' . $repair->equipment->number . ', ' . $repair->equipment->name }}
                                            </td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Краткое описание
                                                ремонта:
                                            </th>
                                            <td class="px-6 py-4"> {{ $repair->short_description }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Полное описание
                                                ремонта:
                                            </th>
                                            <td class="px-6 py-4"> {{ $repair->full_description }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Тип:</th>
                                            <td class="px-6 py-4">
                                                @if($repair->type)
                                                    {{ $repair->type->name }}
                                                @else
                                                    не задан
                                                @endif
                                            </td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Cтатус:</th>
                                            <td class="px-6 py-4">
                                                {{ $repair->status->name }}
                                            </td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата начала</th>
                                            <td class="px-6 py-4">
                                                @if($repair->start_date)
                                                    {{ $repair->start_date->format('d.m.Y') }}
                                                @else
                                                    не задана
                                                @endif
                                            </td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата окончания</th>
                                            <td class="px-6 py-4">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($repair->getMedia('before')->count() > 0 || $canManageImages)
                    <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="">
                                        <h2 class="mb-2 text-lg font-medium text-gray-900">
                                            Фотографии до выполнения ремонта
                                        </h2>

                                        @if($canManageImages)
                                            <x-button-add-files-with-modal
                                                description="Выберите одну или несколько фотографий. Допустимые форматы jpg, png, gif. Ширина и высота изображения не более 4000 пикселей. Размер каждого файла не более 10Мб."
                                                innerButtonText="Добавить"
                                                :route="route('repairs.store-before-images', $repair->id)"
                                                class=""
                                                modalId="uploadBeforeImages"
                                            >
                                                Добавить фотографии
                                            </x-button-add-files-with-modal>
                                        @endif

                                        <div data-te-lightbox-init>
                                            <div class="-m-1 flex flex-wrap justify-start mt-2">
                                                @foreach($repair->getMedia('before') as $image)
                                                    <div class="flex md:w-1/3 flex-wrap w-full">
                                                        <div class="w-full p-1 md:p-2 flex flex-col items-center relative">
                                                            @if($canManageImages)
                                                                <x-button-delete-picture-with-modal
                                                                    class="self-end absolute -top-1"
                                                                    :imageIndex="$loop->index"
                                                                    modalId="deleteBeforeImages"
                                                                    :route="route('repairs.destroy-before-image', ['repair' => $repair->id, 'image_index' => $loop->index])"
                                                                />
                                                            @endif
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
            @endif

            @if($repair->getMedia('after')->count() > 0 || $canManageImages)
                    <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="">
                                        <h2 class="mb-2 text-lg font-medium text-gray-900">
                                            Фотографии после выполнения ремонта
                                        </h2>

                                        @if($canManageImages)
                                            <x-button-add-files-with-modal
                                                description="Выберите одну или несколько фотографий. Допустимые форматы jpg, png, gif. Ширина и высота изображения не более 4000 пикселей. Размер каждого файла не более 10Мб."
                                                innerButtonText="Добавить"
                                                :route="route('repairs.store-after-images', $repair->id)"
                                                class=""
                                                modalId="uploadAfterImages"
                                            >
                                                Добавить фотографии
                                            </x-button-add-files-with-modal>
                                        @endif

                                        <div data-te-lightbox-init>
                                            <div class="-m-1 flex flex-wrap justify-start mt-2">
                                                @foreach($repair->getMedia('after') as $image)
                                                    <div class="flex md:w-1/3 flex-wrap w-full">
                                                        <div class="w-full p-1 md:p-2 flex flex-col items-center relative">
                                                            @if($canManageImages)
                                                                <x-button-delete-picture-with-modal
                                                                    class="self-end absolute -top-1"
                                                                    :imageIndex="$loop->index"
                                                                    modalId="deleteAfterImages"
                                                                    :route="route('repairs.destroy-after-image', ['repair' => $repair->id, 'image_index' => $loop->index])"
                                                                />
                                                            @endif
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
            @endif

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
                                        <td class="px-6 py-4"> {{ $repair->created_at }}</td>
                                    </tr>
                                    <tr
                                        class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                        <th scope="row" class="px-2 py-4 text-right">Последнее изменение основных
                                            данных:
                                        </th>
                                        <td class="px-6 py-4"> {{ $repair->updated_at }}</td>
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
