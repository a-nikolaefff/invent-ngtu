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

<x-layouts.app title="Панель пользователя">

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Панель пользователя
        </h1>
    </div>

    <div>
        <div class="grid grid-cols-3 gap-7">
        @foreach($menu as $menuItem)

                <a href="{{ route($menuItem['route']) }}">
                    <div
                        class="block rounded-lg bg-white border-2  p-6
                    shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]
                    dark:bg-neutral-700">
                        <h5
                            class="flex content-center mb-2 text-xl font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                            <i class="sidebar__icon text-emerald-600 bx {{ $menuItem['boxIconClass'] }}"></i>
                            <span class="ms-2">{{ $menuItem['title'] }}</span>
                        </h5>
                    </div>
                </a>
        @endforeach
        </div>
    </div>


</x-layouts.app>
