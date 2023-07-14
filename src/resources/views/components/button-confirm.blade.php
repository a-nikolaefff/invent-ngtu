@props(['type' => 'submit'])

<button
    type="{{$type}}"
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-block rounded bg-gray-800
    md:px-6 px-2 pb-2 pt-2.5 text-sm font-medium
    leading-normal text-white text-xs uppercase shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150
    ease-in-out hover:bg-gray-700
    hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    focus:outline-none focus:ring-0 active:bg-gray-700
    active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]']) }}>
    {{ $slot }}
</button>

