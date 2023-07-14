<div id="optionSelector" data-value="{{$parameterName}}">

    @if($allOptionsSelector)
        <a href="{{ $url }}" data-value="allOptionsSelection">
            <x-button-secondary-outline>
                {{ $allOptionsSelector }}
            </x-button-secondary-outline>
        </a>
    @endif

    @foreach($options as $option)
        <a href="{{ $url }}" data-value="{{ $option->{$passingProperty} }}">
            <x-button-secondary-outline>
                {{ $option->{$displayingProperty} }}
            </x-button-secondary-outline>
        </a>
    @endforeach

    @if($notSpecifiedOptionSelector)
        <a href="{{ $url }}" data-value="none">
            <x-button-secondary-outline>
                {{ $notSpecifiedOptionSelector }}
            </x-button-secondary-outline>
        </a>
    @endif

</div>
