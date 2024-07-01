@php
    $user = Auth::user();

     $menu = [];

     if($user->can('viewAny', \App\Models\User::class)) {
         $menu[] =  [
                    'title' => 'Пользователи',
                    'route' => 'users.index',
                    'boxIconClass' => 'bx-user',
                ];
     }

          if($user->can('viewAny', \App\Models\Department::class)) {
         $menu[] =                              [
                    'title' => 'Подразделения',
                    'route' => 'departments.index',
                    'boxIconClass' => 'bx-sitemap',
                ];
     }

                    if($user->can('viewAny', \App\Models\DepartmentType::class)) {
         $menu[] =                              [
                    'title' => 'Типы подразделений',
                    'route' => 'department-types.index',
                    'boxIconClass' => 'bx-layer',
                ];
     }



     if($user->can('viewAny', App\Models\BuildingType::class)) {
         $menu[] = [
                'title' => 'Типы зданий',
                 'route' => 'building-types.index',
                 'boxIconClass' => 'bx-home',
            ];
     }

     if($user->can('viewAny', App\Models\RoomType::class)) {
         $menu[] =  [
                'title' => 'Типы помещений',
                 'route' => 'room-types.index',
                 'boxIconClass' => 'bx-category',
            ];
     }

     if($user->can('viewAny', App\Models\EquipmentType::class)) {
         $menu[] = [
                'title' => 'Типы оборудования',
                'route' => 'equipment-types.index',
                'boxIconClass' => 'bx-list-ul',
            ];
     }

     if($user->can('viewAny', App\Models\RepairType::class)) {
         $menu[] = [
                'title' => 'Типы ремонтов',
                'route' => 'repair-types.index',
                 'boxIconClass' => 'bx-cog',
            ];
     }
@endphp

<x-layouts.admin title="Панель администратора">

    <div class="page-header page-header_not-centered">
        <h1 class="h1">
            Панель администратора
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
                            <i class="sidebar__icon text-pink-600 bx {{ $menuItem['boxIconClass'] }}"></i>
                            <span class="ms-2">{{ $menuItem['title'] }}</span>
                        </h5>
                    </div>
                </a>






        @endforeach
        </div>
    </div>


</x-layouts.admin>
