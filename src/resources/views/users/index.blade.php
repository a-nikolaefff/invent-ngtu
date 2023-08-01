<x-admin-layout title="Пользователи">

    @if (session('status') === 'user-deleted')
        <x-alert type="success" class="mb-4">
            Пользователь удален
        </x-alert>
    @endif

    <h1 class="mb-3 font-semibold text-xl text-gray-800 leading-tight">
        Пользователи
    </h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">

                    <div class="flex mb-3">
                        <div class="w-full md:w-8/12 lg:w-1/2">
                            <x-search-form
                                :value="request()->search"
                                placeholder="Поиск по имени, email или подразделению"
                            ></x-search-form>
                        </div>
                        <div></div>
                    </div>

                    <div class="flex mb-2">
                        <div class="w-full md:w-8/12 lg:w-4/12">
                            <x-input-label value="Роль" class="mb-1"/>
                            <x-option-selector
                                id="optionSelector1"
                                :url="route('users.index')"
                                parameter-name="role_id"
                                :options="$roles"
                                passing-property='id'
                                displaying-property='name'
                                all-options-selector='любая роль'
                            ></x-option-selector>
                        </div>
                        <div></div>
                    </div>

                    @if($users->count() === 0)
                        <p class="h5 ">
                            Результаты не найдены
                        </p>
                    @else

                    <table class="table-fixed min-w-full text-left text-sm  font-light
                    mx-auto max-w-4xl w-full rounded-lg bg-white divide-y divide-gray-300 overflow-hidden"
                           id="sortableTable">
                        <thead class="border-b font-medium dark:border-neutral-500">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('users.index', ['sort' => 'name', 'direction' => 'asc']) }}"
                                >
                                    Имя
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4 hidden sm:table-cell">
                                <a class="d-block"
                                   href="{{ route('users.index', ['sort' => 'email', 'direction' => 'asc']) }}"
                                >
                                    Email
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('users.index', ['sort' => 'department_name', 'direction' => 'asc']) }}"
                                >
                                    Подразделение
                                </a>
                            </th>

                            <th scope="col" class="px-6 py-4 hidden lg:table-cell">
                                <a class="d-block"
                                   href="{{ route('users.index', ['sort' => 'role_id', 'direction' => 'asc']) }}"
                                >
                                    Роль
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                        <tr
                            onclick="window.location='{{ route('users.show', $user->id) }}';"
                            class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100
                            dark:border-neutral-500 dark:hover:bg-neutral-600">

                            <td class="px-6 py-4">{{ $user->name }}</td>

                            <td class="px-6 py-4 hidden sm:table-cell">{{ $user->email }}</td>

                            <td class="px-6 py-4 hidden lg:table-cell">
                                @if($user->department)
                                    {{ $user->department->name }}
                                @else
                                    не задано
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 hidden lg:table-cell">{{ $user->role->name }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>

                    @endif


            </div>
        </div>
    </div>

</x-admin-layout>
