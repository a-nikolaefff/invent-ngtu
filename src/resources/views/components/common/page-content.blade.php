@props(['centered' => false, 'overflowXAuto' => true])

<main class="page__content content py-4">
    <div class="sm:container mx-auto">
        <div class="sm:-mx-6 lg:-mx-8">
            <div class="@if($overflowXAuto) overflow-x-auto @endif min-w-full py-2 sm:px-6 lg:px-8">
                @if($centered)
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 py-3">
                        <div class="space-y-4">
                            {{ $slot }}
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
