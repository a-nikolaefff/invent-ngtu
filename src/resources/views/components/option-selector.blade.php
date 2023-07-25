<div id="optionSelector" data-value="{{$parameterName}}">

    <select id="role" name="role_id" data-te-select-init>

        @if($allOptionsSelector)
            <option
                value="allOptionsSelection">
                {{ $allOptionsSelector }}
            </option>
        @endif

        @foreach($options as $option)
            <option
                value="{{ $option->{$passingProperty} }}">
                {{ $option->{$displayingProperty} }}
            </option>
        @endforeach

        @if($notSpecifiedOptionSelector)
            <option
                value="none">
                {{ $notSpecifiedOptionSelector }}
            </option>
        @endif
    </select>
</div>
