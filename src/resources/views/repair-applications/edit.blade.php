<x-app-layout title="Отправка ответа на заявку" :centered="true" :overflowXAuto="false">

<div class="page-header">
    <h1 class="h1">
        Отправка ответа на заявку
    </h1>
</div>

<div class="content-block">

    <h2 class="mb-2 h2">
        Основные данные
    </h2>


    <form method="POST"
          action="{{ route('repair-applications.update', $repairApplication->id) }}">
        @method('PUT')
        @csrf

        <div class="form-wrapper">
            <div class="max-w-xl">
                <x-forms.input-label for="repairApplicationStatus" value="Статус заявки"/>
                <select id="repairApplicationStatus" name="repair_application_status_id"
                        data-te-select-init>
                    @foreach($repairApplicationStatuses as $status)
                        <option
                            value="{{ $status->id }}" {{ old('repair_application_status_id', $repairApplication->status->id) == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                <x-forms.input-error :messages="$errors->get('repair_application_status_id')"/>
            </div>

            <div class="max-w-4xl">
                <x-forms.input-label for="response" value="Ответ на заявку"/>
                <x-forms.textarea id="response"
                                  name="response"
                                  type="text"
                                  rows="5"
                                  maxlength="555"
                >{{ old('response', $repairApplication->response) }}</x-forms.textarea>
                <x-forms.input-error :messages="$errors->get('response')"/>
            </div>

            <x-buttons.confirm>
                Отправить ответ
            </x-buttons.confirm>
        </div>
    </form>
</div>
</x-app-layout>
