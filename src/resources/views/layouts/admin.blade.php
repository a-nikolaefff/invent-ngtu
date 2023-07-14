@props(['title'])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title }} | {{ config('app.name', 'Laravel') }}
    </title>

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="page" id="page">
    <x-header
        :is-page-with-admin-sidebar="true"
    ></x-header>
    <x-sidebar
        :is-admin-sidebar="true"
        :menu="[
                [
                    'title' => 'Пользователи',
                    'route' => 'users.index',
                    'boxIconClass' => 'bx-user',
                ],
                [
                    'title' => 'Типы подразделений',
                    'route' => 'profile.edit',
                    'boxIconClass' => 'bx-layer',
                ],
                [
                    'title' => 'Типы зданий',
                    'route' => 'profile.edit',
                    'boxIconClass' => 'bx-building-house',
                ],
                [
                    'title' => 'Типы комнат',
                    'route' => 'profile.edit',
                    'boxIconClass' => 'bx-spreadsheet',
                ],
                [
                    'title' => 'Типы оборудования',
                    'route' => 'profile.edit',
                    'boxIconClass' => 'bx-collection',
                ],
            ]"
    ></x-sidebar>
    <main class="page__content content py-4">
        <div class="md:container md:mx-auto">
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
