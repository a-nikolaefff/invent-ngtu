<header class="header" id="header">
    <i class="header__toggle @if($isPageWithAdminSidebar) header__toggle_admin @endif bx bx-menu"
       id="header__toggle"></i>

    <div class="header__container container">
        @guest
            <div class="header__authorisation ms-1">
                <a class="nav-link me-1 me-sm-3" href="{{ route('login') }}">
                    <button type="button" class="btn btn-primary">Вход</button>
                </a>
                <a class="nav-link" href="{{ route('register') }}">
                    <button type="button" class="btn btn-secondary">Регистрация</button>
                </a>
            </div>
        @else

            @can('viewAny', App\Models\User::class)
                @if($isPageWithAdminSidebar)
                    <a href="{{ route('departments.index') }}">
                        <x-button-primary>
                            <span class="hidden sm:inline-flex">
                                Панель пользователя
                            </span>
                            <span class="sm:hidden">
                                Пол. панель
                            </span>
                        </x-button-primary>
                    </a>
                @else
                    <a href="{{ route('users.index') }}">
                        <x-button-secondary>
                            <span class="hidden sm:inline-flex">
                                Панель администратора
                            </span>
                            <span class="sm:hidden">
                                Админ. панель
                            </span>
                        </x-button-secondary>
                    </a>
                @endif
            @endcan


            <div class="relative" data-te-dropdown-ref>
                <a
                    class="flex items-center px-4 md:px-6
                    pb-2 pt-2.5 text-sm text-right font-medium leading-normal"
                    href=""
                    type="button"
                    id="dropdownMenuButton2"
                    data-te-dropdown-toggle-ref
                    aria-expanded="false"
                    data-te-ripple-init
                    data-te-ripple-color="light">
                    {{ Auth::user()->name }}
                    <span class="ml-2 w-2">
      <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="h-5 w-5">
        <path
            fill-rule="evenodd"
            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
            clip-rule="evenodd"/>
      </svg>
    </span>
                </a>
                <ul
                    class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg
                     border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700
                     [&[data-te-dropdown-show]]:block"
                    aria-labelledby="dropdownMenuButton2"
                    data-te-dropdown-menu-ref>
                    <li>
                        <a
                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                            href="{{ route('profile.edit') }}"
                            data-te-dropdown-item-ref
                        >Профиль пользователя</a
                        >
                    </li>
                    <li>
                        <a
                            class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal
                            text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline
                            disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400
                            dark:text-neutral-200 dark:hover:bg-neutral-600"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >Выйти из аккаунта</a
                        >
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>

        @endguest
    </div>
</header>
