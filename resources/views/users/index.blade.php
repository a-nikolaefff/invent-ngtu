<x-layouts.admin title="Пользователи">

    @if (session('status') === 'user-deleted')
        <x-alert type="success">
            Пользователь удален
        </x-alert>
    @endif


    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Пользователи
        </h1>
    </div>

    <x-search-form
        class="w-full lg:w-10/12 xl:w-1/2"
        :value="request()->search"
        placeholder="Поиск по имени, email или подразделению"
    />

    <x-option-selector
        class="w-full md:w-8/12 lg:w-4/12"
        id="optionSelector1"
        label="Роль"
        :options="$roles"
        parameter="role_id"
        passing-property='id'
        displaying-property='name'
        all-options-selection='любая роль'
    />

    @if($users->count() === 0)
        <p class="block">
            Результаты не найдены
        </p>
    @else

        <table class="standard-table standard-table_clickable mx-auto" id="sortableTable">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('users.index', ['sort' => 'name', 'direction' => 'asc']) }}">
                        Имя
                    </a>
                </th>

                <th scope="col" class="hidden sm:table-cell">
                    <a class="d-block" href="{{ route('users.index', ['sort' => 'email', 'direction' => 'asc']) }}">
                        Email
                    </a>
                </th>

                <th scope="col" class="hidden lg:table-cell">
                    <a href="{{ route('users.index', ['sort' => 'department_name', 'direction' => 'asc']) }}">
                        Подразделение
                    </a>
                </th>

                <th scope="col" class="hidden lg:table-cell">
                    <a href="{{ route('users.index', ['sort' => 'role_id', 'direction' => 'asc']) }}">
                        Роль
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
                <tr onclick="window.location='{{ route('users.show', $user->id) }}';">
                    <td>{{ $user->name }}</td>
                    <td class="hidden sm:table-cell">{{ $user->email }}</td>
                    <td class="hidden lg:table-cell">
                        @if($user->department)
                            {{ $user->department->name }}
                        @else
                            не задано
                        @endif
                    </td>
                    <td class="hidden lg:table-cell">{{ $user->role->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    @endif

</x-layouts.admin>
