<x-app-layout title="Профиль">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status') === 'profile-updated')
                <x-alert type="success" class="mb-4">
                    Персональные данные успешно изменены
                </x-alert>
            @endif

            @if (session('status') === 'password-updated')
                <x-alert type="success" class="mb-4">
                    Пароль успешно изменен
                </x-alert>
            @endif

            <h1 class=" sm:px-8 font-semibold text-xl text-gray-800 leading-tight">
                Профиль
            </h1>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Служебные данные
                                    </h2>

                                    <table class="min-w-full text-left text-sm font-light">
                                        <tbody>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Роль в системе:</th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->role->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Должность:</th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->post }}</td>
                                        </tr>

                                        <tr
                                            @if($user->department)
                                                @can('view', $user->department)
                                                    onclick="window.location='{{ route('departments.show', $user->department->id) }}';"
                                            class="clickable border-b transition duration-300 ease-in-out
                                             hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600"
                                                @else
                                                    class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                                @endcan
                                            @else
                                                class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                            @endif
                                        >
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Подразделение:</th>
                                            <td class="whitespace-nowrap px-6 py-4">
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
                            </div>
                        </div>
                    </div>

            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Хронологические данные
                                    </h2>

                                    <table class="min-w-full text-left text-sm font-light">
                                        <tbody>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-2/12 px-2 py-4 text-right">Регистрация:</th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->created_at }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="px-2 py-4 text-right">Последнее изменение <br>
                                                профиля:
                                            </th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->updated_at }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
