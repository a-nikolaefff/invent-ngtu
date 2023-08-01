<div class="sidebar @if($isAdminSidebar) sidebar_admin @endif" id="sidebar">
    <nav class="sidebar__content">
            <a class="sidebar__logo" href="{{ url('/') }}">
                <span class="sidebar__logo-icon"></span>
                <span class="sidebar__logo-name">ИНВЕНТ НГТУ</span>
            </a>
            @foreach($menu as $item)
            <a href="{{ route($item['route']) }}"
                   class="sidebar__link @if(request()->routeIs($item['route'])) sidebar__link_active @endif">
                    <i class="sidebar__icon bx {{ $item['boxIconClass'] }}"></i>
                    <span class="nav_name">{{ $item['title'] }}</span>
                </a>
            @endforeach
    </nav>
</div>
