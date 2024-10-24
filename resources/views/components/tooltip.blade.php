@props(['text'])

<div class='has-tooltip w-7'>
    <span class='max-w-fit tooltip rounded shadow-lg p-1 bg-gray-900 text-white -mt-8'>
        {{ $text }}
    </span>
    <button class="w-6 h-6 px-1 py-1 text-xs font-medium text-white bg-gray-900 rounded-full">?</button>
</div>
