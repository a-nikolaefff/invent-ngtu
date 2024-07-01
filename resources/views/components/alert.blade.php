@props(['type' => 'primary'])

@php
$styles = match ($type) {
    'success' => 'bg-success-100 text-success-700',
    'danger' => 'bg-danger-100 text-danger-700',
}
@endphp

<div
    {{ $attributes->merge(['role' => 'alert', 'class' => "rounded-lg px-6 py-5 text-base $styles"]) }}>
    {{ $slot }}
</div>
