@props(['description', 'route', 'innerButtonText', 'modalId' => 'uploadАFilesModal'])

<!-- Button trigger modal -->
<button
    {{ $attributes->merge([
    'type' => 'button',
    'data-te-toggle' => 'modal',
    'data-te-target' => "#$modalId",
    'class' => 'inline-block rounded bg-emerald-600 md:px-6 px-2 pb-2 pt-2.5 text-sm font-medium
    leading-normal text-white text-xs uppercase shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150
    ease-in-out hover:bg-emerald-500
    hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    focus:bg-emerald-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    focus:outline-none focus:ring-0 active:bg-emerald-700
    active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]']) }}>
    {{ $slot }}
</button>

<!-- Modal -->
<div
    data-te-modal-init
    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="{{ $modalId }}"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
        <div
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <form method="post" action="{{ $route }}" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900">
                        Добавление фотографий оборудования
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 mb-4">
                        {{ $description }}
                    </p>

                    <x-forms.file-input multiple id="images" name="images[]"
                                  class="mt-1 block w-full"/>

                    <div class="mt-6 flex justify-end">

                        <x-buttons.cancel
                            class="mr-2"
                            data-te-modal-dismiss>
                            Отмена
                        </x-buttons.cancel>

                        <x-buttons.confirm>
                            {{ $innerButtonText }}
                        </x-buttons.confirm>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
