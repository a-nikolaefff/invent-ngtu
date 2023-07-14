<x-admin-layout :title="'Пользователь: ' . $user->name">

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="sm:px-8">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ 'Пользователь: ' . $user->name }}
                </h1>

                @can('update', $user)
                    <div class="my-3">
                        <span class="mr-2">
                            <a href="{{ route('users.edit', $user->id) }}">
                                <x-button-edit>
                                    Редактировать
                                </x-button-edit>
                            </a>
                        </span>
                        @can('delete', $user)
                            <x-button-delete-with-modal
                                question="Вы уверены, что хотите удалить данного пользователя?"
                                warning="Это действие удалит пользователя, а также все созданные им заявки на ремонт."
                                :route="route('users.destroy', $user->id)"
                            >
                                Удалить
                            </x-button-delete-with-modal>
                        @endcan
                    </div>
                @endcan
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Персональные данные
                                    </h2>

                                    <table class="min-w-full text-left text-sm font-light">
                                        <tbody>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                                        >
                                            <th scope="row" class="w-4/12 px-2 py-4 text-right">Имя:</th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->name }}</td>
                                        </tr>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="px-2 py-4 text-right">Email:</th>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                <a class="text-blue-600 dark:text-blue-500 hover:underline"
                                                   href="mailto:{{$user->email}}">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
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
                                            <th scope="row" class="w-4/12 px-2 py-4 text-right">Роль в системе:</th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->role->name }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <h2 class="mb-2 text-lg font-medium text-gray-900">
                                        Временные данные
                                    </h2>

                                    <table class="min-w-full text-left text-sm font-light">
                                        <tbody>

                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="w-4/12 px-2 py-4 text-right">Регистрация:</th>
                                            <td class="whitespace-nowrap px-6 py-4"> {{ $user->created_at }}</td>
                                        </tr>
                                        <tr
                                            class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                            <th scope="row" class="px-2 py-4 text-right">Подтверждение email:</th>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                @if($user->email_verified_at)
                                                    {{ $user->email_verified_at }}
                                                @else
                                                    не подтвержден
                                                @endif
                                            </td>
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
            </div>
        </div>
    </div>
</x-admin-layout>
