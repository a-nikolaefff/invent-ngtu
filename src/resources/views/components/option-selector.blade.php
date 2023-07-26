<div {{ $attributes->merge(['data-value' => $parameterName]) }}>

    <select id="role" name="role_id" data-te-select-init>

        @if($allOptionsSelector)
            <option
                value="allOptionsSelection">
                {{ $allOptionsSelector }}
            </option>
        @endif

        @if($notSpecifiedOptionSelector)
            <option
                value="none">
                {{ $notSpecifiedOptionSelector }}
            </option>
        @endif

        @foreach($options as $option)
            <option
                value="{{ $option->{$passingProperty} }}">
                {{ $option->{$displayingProperty} }}
            </option>
        @endforeach
    </select>
</div>
