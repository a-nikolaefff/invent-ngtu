@props(['label', 'parameter', 'options', 'displayingProperty', 'passingProperty',
 'allOptionsSelection', 'notSpecifiedOptionSelection'])

<div {{ $attributes->merge(['data-value' => $parameter]) }}>
    <x-forms.input-label value="{{ $label }}" class="mb-1"/>

    <select data-te-select-init>

        @isset($allOptionsSelection)
            <option
                value="allOptionsSelection">
                {{ $allOptionsSelection }}
            </option>
        @endisset

        @isset($notSpecifiedOptionSelection)
                <option
                    value="none">
                    {{ $notSpecifiedOptionSelection }}
                </option>
        @endisset

        @foreach($options as $option)
            <option
                value="{{ $option->{$passingProperty} }}">
                {{ $option->{$displayingProperty} }}
            </option>
        @endforeach
    </select>
</div>
