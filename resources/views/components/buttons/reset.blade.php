@props(['type' => 'button'])

<button
    {{ $attributes->merge(['type' => $type, 'class' => 'mr-0.5 relative z-[2] border-2 rounded-md border-red-600
                 px-2 py-2 leading-none
                 font-medium uppercase text-red-600 transition duration-150 ease-in-out
                 hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0']) }}>
    {{ $slot }}
</button>
