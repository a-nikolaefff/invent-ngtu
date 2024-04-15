@props(['$isAdminSidebar', 'menu'])

<div class="sidebar @if($isAdminSidebar) sidebar_admin @endif" id="sidebar">
    <nav class="sidebar__content">
            <a class="sidebar__logo" href="{{ url('/') }}">
                <span class="sidebar__logo-icon"></span>
                <span class="sidebar__logo-name">ИНВЕНТ НГТУ</span>
            </a>
        @if($isAdminSidebar)
            <a href="{{ route('admin-main') }}"
               class="sidebar__link @if(request()->routeIs('admin-main')) sidebar__link_active @endif">
                <i class="sidebar__icon bx bx-windows"></i>
                <span class="nav_name">Главная</span>
            </a>
        @else
            <a href="{{ route('user-main') }}"
               class="sidebar__link @if(request()->routeIs('user-main')) sidebar__link_active @endif">
                <i class="sidebar__icon bx bx-windows"></i>
                <span class="nav_name">Главная</span>
            </a>
        @endif
            @foreach($menu as $item)
            <a href="{{ route($item['route']) }}"
                   class="sidebar__link @if(request()->routeIs($item['route'])) sidebar__link_active @endif">
                    <i class="sidebar__icon bx {{ $item['boxIconClass'] }}"></i>
                    <span class="nav_name">{{ $item['title'] }}</span>
                </a>
            @endforeach
    </nav>
</div>
