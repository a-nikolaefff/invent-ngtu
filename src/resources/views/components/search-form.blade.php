<form id="searchForm" method="GET" role="search" autocomplete="off">

{{--    <div class="search-form input-group">--}}
{{--        <input id="searchInput" name="search" class="form-control" type="search"--}}
{{--               placeholder="{{ $placeholder }}"--}}
{{--               aria-label="Search" @if(isset($value)) value="{{ $value }}" @endif>--}}

{{--        <button id="resetButton" class="search-form__reset-button btn btn-outline-danger" type="button">--}}
{{--            <i class='bx bx-x-circle bx-sm'></i>--}}
{{--        </button>--}}

{{--        <button class="search-form__search-button btn btn-outline-success" type="submit">--}}
{{--            <i class='bx bx-search bx-sm'></i>--}}
{{--        </button>--}}
{{--    </div>--}}

    <div>
        <div class="search-form relative flex w-full flex-wrap items-stretch">
            <input
                id="searchInput"
                name="search"
                type="search"
                class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                placeholder="{{ $placeholder }}"
                aria-label="Search"
                aria-describedby="button-addon3"
                @if(isset($value)) value="{{ $value }}" @endif
            />

            <!--Reset button-->
            <button
                id="resetButton"
                class="mr-0.5 search-form__reset-button relative z-[2] border-2 border-red-600 px-6 py-2
                 font-medium uppercase text-red-600 transition duration-150 ease-in-out
                 hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                type="button"
                id="button-addon3"
                data-te-ripple-init>
                Сброс
            </button>


            <!--Search button-->
            <button
                class="search-form__search-button relative z-[2] rounded-r border-2 border-emerald-600 px-6
                 py-2 font-medium uppercase text-emerald-600 transition duration-150 ease-in-out
                 hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
                type="submit"
                id="button-addon3"
                data-te-ripple-init>
                Искать
            </button>
        </div>
    </div>


</form>
