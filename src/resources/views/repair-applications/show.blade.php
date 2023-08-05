@php
    $canManageImages = \Illuminate\Support\Facades\Auth::user()
    ->can('manageImages', $repairApplication);

    $canViewUserInformation = \Illuminate\Support\Facades\Auth::user()
    ->can('viewUserInformation', App\Models\RepairApplication::class);
@endphp

<x-app-layout :title="'Заявка на ремонт: ' . $repairApplication->name">

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
                @case('repair-application-updated')
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
                    {{ 'Заявка на ремонт: ' . $repairApplication->short_description }}
                </h1>

                @canany(['update', 'delete'], $repairApplication)
                    <div class="my-4">
                        @can('update', $repairApplication)
                            <a href="{{ route('repair-applications.edit', $repairApplication->id) }}">
                                <x-button-edit class="mr-2">
                                    Ответить на заявку
                                </x-button-edit>
                            </a>
                        @endcan
                        @can('delete', $repairApplication)
                            <x-button-delete-with-modal
                                question="Вы уверены, что хотите удалить данную заявку?"
                                warning="Это действие безвозвратно удалит данную заявку."
                                :route="route('repair-applications.destroy', $repairApplication->id)"
                            >
                                Удалить
                            </x-button-delete-with-modal>
                        @endcan
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
                                            onclick="window.location='{{ route('equipment.show', $repairApplication->equipment->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"

                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">
                                                Неисправное оборудование:
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ 'инв. № ' . $repairApplication->equipment->number . ', ' . $repairApplication->equipment->name }}
                                            </td>
                                        </tr>

                                        @if($canViewUserInformation)
                                            <tr
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            >
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Отправитель:
                                                </th>
                                                <td class="px-6 py-4"> {{ $repairApplication->user->name }}</td>
                                            </tr>
                                        @endif

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Краткое описание заявки:
                                            </th>
                                            <td class="px-6 py-4"> {{ $repairApplication->short_description }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Расширенное описание
                                                заявки:
                                            </th>
                                            <td class="px-6 py-4"> {{ $repairApplication->full_description }}</td>
                                        </tr>


                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата подачи</th>
                                            <td class="px-6 py-4">
                                                {{ $repairApplication->application_date->format('d.m.Y') }}
                                            </td>
                                        </tr>


                                        @if($repairApplication->response_date)
                                            <tr
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            >
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Дата ответа</th>
                                                <td class="px-6 py-4">
                                                    {{ $repairApplication->response_date->format('d.m.Y') }}
                                                </td>
                                            </tr>
                                        @endif

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Cтатус:</th>
                                            <td class="px-6 py-4 font-medium
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
                                            <tr
                                                class="border-b bg-slate-50 dark:border-neutral-500 dark:bg-neutral-600"
                                            >
                                                <th scope="row" class="w-2/12 px-2 py-4 text-right">Ответ по заявке:
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $repairApplication->response }}
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

            @if($repairApplication->getMedia('images')->count() > 0 || $canManageImages)
                <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Приложенные фотографии
                                    </h2>

                                    @if($canManageImages)
                                        <x-button-add-files-with-modal
                                            description="Выберите одну или несколько фотографий. Допустимые форматы jpg, png, gif. Ширина и высота изображения не более 4000 пикселей. Размер каждого файла не более 10Мб."
                                            innerButtonText="Добавить"
                                            :route="route('repair-applications.store-images', $repairApplication->id)"
                                            class=""
                                            modalId="uploadBeforeImages"
                                        >
                                            Добавить фотографии
                                        </x-button-add-files-with-modal>
                                    @endif

                                    <div data-te-lightbox-init>
                                        <div class="-m-1 flex flex-wrap justify-start mt-2">
                                            @foreach($repairApplication->getMedia('images') as $image)
                                                <div class="flex md:w-1/3 flex-wrap w-full">
                                                    <div class="w-full p-1 md:p-2 flex flex-col items-center relative">
                                                        @if($canManageImages)
                                                            <x-button-delete-picture-with-modal
                                                                class="self-end absolute -top-1"
                                                                :imageIndex="$loop->index"
                                                                modalId="deleteBeforeImages"
                                                                :route="route('repair-applications.destroy-image', ['repairApplication' => $repairApplication->id, 'image_index' => $loop->index])"
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
        </div>
    </div>
</x-app-layout>
