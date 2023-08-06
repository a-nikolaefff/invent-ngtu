<x-app-layout title="Профиль" :centered="true">

    @if (session('status') === 'profile-updated')
        <x-alert type="success">
            Персональные данные успешно изменены
        </x-alert>
    @endif

    @if (session('status') === 'password-updated')
        <x-alert type="success">
            Пароль успешно изменен
        </x-alert>
    @endif

    <div class="page-header">
        <h1 class="h1">
            Профиль
        </h1>
    </div>

    <div class="content-block">
        <h2 class="h2">
            Служебные данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>

            <tr>
                <th scope="row" class="w-2/12">Роль в системе:</th>
                <td> {{ $user->role->name }}</td>
            </tr>

            <tr>
                <th scope="row" class="w-2/12">Должность:</th>
                <td> {{ $user->post }}</td>
            </tr>

            <tr
                @if($user->department)
                    @can('view', $user->department)
                        onclick="window.location='{{ route('departments.show', $user->department->id) }}';"
                class="standard-table__clickable-row"
                @endcan
                @endif
            >
                <th scope="row" class="w-2/12">Подразделение:</th>
                <td>
                    @if($user->department)
                        {{ $user->department->name }}
                    @else
                        нет
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Хронологические данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>
            <tr>
                <th scope="row" class="w-2/12">Регистрация:</th>
                <td> {{ $user->created_at }}</td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение профиля:</th>
                <td> {{ $user->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="content-block">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="content-block">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="content-block">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</x-app-layout>
