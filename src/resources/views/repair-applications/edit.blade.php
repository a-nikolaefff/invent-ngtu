<x-app-layout title="Отправка ответа на заявку">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
                    Отправка ответа на заявку
                </h1>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">
                        <div class="sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Основные данные
                                    </h2>

                                    <div>
                                        <form method="POST"
                                              action="{{ route('repair-applications.update', $repairApplication->id) }}">
                                            @method('PUT')
                                            @csrf

                                            <div class="max-w-xl mb-3">
                                                <x-input-label for="repairApplicationStatus" value="Статус заявки" class="mb-1"/>
                                                <select id="repairApplicationStatus" name="repair_application_status_id"
                                                        class="mb-3"
                                                        data-te-select-init>
                                                    @foreach($repairApplicationStatuses as $status)
                                                        <option
                                                            value="{{ $status->id }}" {{ old('repair_application_status_id', $repairApplication->status->id) == $status->id ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error class="mt-2" :messages="$errors->get('repair_application_status_id')"/>
                                            </div>

                                            <div class="max-w-4xl mb-3">
                                                <x-input-label for="response" value="Ответ на заявку"/>
                                                <x-textarea id="response"
                                                            name="response"
                                                            type="text"
                                                            rows="5"
                                                            maxlength="555"
                                                            class="mt-1 block w-full">{{ old('response', $repairApplication->response) }}</x-textarea>
                                                <x-input-error class="mt-2" :messages="$errors->get('response')"/>
                                            </div>

                                            <x-button-confirm class="mt-3">
                                                Отправить ответ
                                            </x-button-confirm>
                                        </form>
                                    </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
