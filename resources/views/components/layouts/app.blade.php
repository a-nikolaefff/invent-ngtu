@props(['title', 'centered' => false, 'overflowXAuto' => true])

@php
    $user = Auth::user();

     $menu = [
         [
             'title' => 'Здания',
             'route' => 'buildings.index',
             'boxIconClass' => 'bx-building-house',
        ],
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
             'route' => 'repairs.index',
             'boxIconClass' => 'bx-wrench',
        ],
        [
            'title' => 'Заявки на ремонт',
             'route' => 'repair-applications.index',
             'boxIconClass' => 'bxs-paper-plane',
        ]
    ];
@endphp

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

    <x-common.header
        :is-page-with-admin-sidebar="false"
    ></x-common.header>

    <x-common.sidebar
        :is-admin-sidebar="false"
        :menu="$menu"
    ></x-common.sidebar>

    <x-common.page-content :centered="$centered" :overflowXAuto="$overflowXAuto">
        {{ $slot }}
    </x-common.page-content>
</div>
</body>
</html>
