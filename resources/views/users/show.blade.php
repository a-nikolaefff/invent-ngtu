<x-layouts.admin :centered="true" :title="'Пользователь: ' . $user->name">

    @if (session('status') === 'user-updated')
        <x-alert type="success">
            Данные успешно изменены
        </x-alert>
    @endif

    <div class="page-header">
        <h1 class="h1">
            {{ 'Пользователь: ' . $user->name }}
        </h1>

        <div class="page-header__buttons">
            @can('update', $user)
                <a href="{{ route('users.edit', $user->id) }}">
                    <x-buttons.edit>
                        Редактировать
                    </x-buttons.edit>
                </a>
            @endcan
            @can('delete', $user)
                <x-buttons.delete-with-modal
                    question="Вы уверены, что хотите удалить данного пользователя?"
                    warning="Это действие удалит пользователя, а также все созданные им заявки на ремонт."
                    :route="route('users.destroy', $user->id)"
                >
                    Удалить
                </x-buttons.delete-with-modal>
            @endcan
        </div>
    </div>

    <div class="content-block">

        <h2 class="h2">
            Персональные данные
        </h2>

        <table class="standard-table standard-table_left-header">
            <tbody>
            <tr>
                <th scope="row" class="w-2/12">Имя:</th>
                <td> {{ $user->name }}</td>
            </tr>

            <tr>
                <th scope="row">Email:</th>
                <td>
                    <a class="text-blue-600 dark:text-blue-500 hover:underline"
                       href="mailto:{{$user->email}}">
                        {{ $user->email }}
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
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
                    onclick="window.location='{{ route('departments.show', $user->department->id) }}';"
                class="standard-table__clickable-row"
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
                <th scope="row">Подтверждение email:</th>
                <td>
                    @if($user->email_verified_at)
                        {{ $user->email_verified_at }}
                    @else
                        не подтвержден
                    @endif
                </td>
            </tr>
            <tr>
                <th scope="row">Последнее изменение профиля:</th>
                <td> {{ $user->updated_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</x-layouts.admin>
