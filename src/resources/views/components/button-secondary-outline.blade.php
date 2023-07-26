@props(['type' => 'button'])

<button
    {{ $attributes->merge(['type' => $type, 'class' => 'mr-2 mb-3 text-pink-600 border-2
    border-pink-600 inline-block rounded px-6 pb-2 pt-2.5 text-sm
    font-medium leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150
    ease-in-out hover:bg-pink-600 hover:border-pink-600 hover:text-white
    hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    focus:bg-pink-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
    focus:outline-none focus:ring-0 active:bg-pink-600
    active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]']) }}>
    {{ $slot }}
</button>
