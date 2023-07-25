<x-admin-layout title="Пользователи">

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
                                placeholder="Поиск по имени или email"
                            ></x-search-form>
                        </div>
                        <div></div>
                    </div>

                    <div class="flex mb-2">
                        <div class="w-full md:w-8/12 lg:w-4/12">
                            <x-input-label value="Роль" />
                            <x-option-selector
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


                    <table class="table-fixed min-w-full text-left text-sm text-center font-light
                    mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden"
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
                            <th scope="col" class="px-6 py-4">
                                <a class="d-block"
                                   href="{{ route('users.index', ['sort' => 'email', 'direction' => 'asc']) }}"
                                >
                                    Email
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-4 hidden md:block">
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
                            class="clickable border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                            <td class="whitespace-nowrap px-6 py-4 truncate max-w-250">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 truncate max-w-250">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4 hidden md:block">{{ $user->role->name }}</td>
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
