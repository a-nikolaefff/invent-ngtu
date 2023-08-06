@props(['title', 'centered' => false, 'overflowXAuto' => true])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {!! $title !!} | {{ config('app.name', 'Laravel') }}
    </title>

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="page" id="page">

    <x-common.header
        :is-page-with-admin-sidebar="true"
    ></x-common.header>

    <x-common.sidebar
        :is-admin-sidebar="true"
        :menu="[
                [
                    'title' => 'Пользователи',
                    'route' => 'users.index',
                    'boxIconClass' => 'bx-user',
                ],
                [
                    'title' => 'Подразделения',
                    'route' => 'departments.index',
                    'boxIconClass' => 'bx-sitemap',
                ],
                [
                    'title' => 'Типы подразделений',
                    'route' => 'department-types.index',
                    'boxIconClass' => 'bx-layer',
                ],
            ]"
    ></x-common.sidebar>

    <x-common.page-content :centered="$centered" :overflowXAuto="$overflowXAuto">
        {{ $slot }}
    </x-common.page-content>

</div>
</body>
</html>
