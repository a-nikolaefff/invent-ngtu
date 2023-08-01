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
        :is-page-with-admin-sidebar="false"
    ></x-header>
    <x-sidebar
        :is-admin-sidebar="false"
        :menu="[
                    [
                    'title' => 'Помещения',
                    'route' => 'rooms.index',
                    'boxIconClass' => 'bx-cube',
                ],
                [
                    'title' => 'Оборудование',
                    'route' => 'equipment.index',
                    'boxIconClass' => 'bx-hdd',
                ],
                [
                    'title' => 'Ремонты',
                    'route' => 'profile.edit',
                    'boxIconClass' => 'bx-wrench',
                ],
                [
                    'title' => 'Заявки на ремонт',
                    'route' => 'profile.edit',
                    'boxIconClass' => 'bx-envelope',
                ],
            ]"
    ></x-sidebar>
    <main class="page__content content py-4">
        <div class="sm:container mx-auto">
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
