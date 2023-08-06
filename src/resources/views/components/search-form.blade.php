<div {{ $attributes->merge() }}>
    <form id="searchForm" method="GET" role="search" autocomplete="off">
        <div class="search-form relative flex w-full flex-wrap items-stretch">
            <input
                id="searchInput"
                name="search"
                type="search"
                class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto
                border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="{{ $placeholder }}"
                aria-label="Search"
                @if(isset($value)) value="{{ $value }}" @endif
            />

            <!--Reset button-->
            <x-buttons.reset
                class="search-form__reset-button px-6 ml-1" id="resetButton" data-te-ripple-init>
                Сброс
            </x-buttons.reset>

            <!--Search button-->
            <button
                class="search-form__search-button relative z-[2] rounded-r border-2 border-emerald-600 px-6
                 py-2 font-medium uppercase text-emerald-600 transition duration-150 ease-in-out
                 hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                type="submit"
                id="searchButton"
                data-te-ripple-init>
                Искать
            </button>
        </div>
    </form>
</div>
