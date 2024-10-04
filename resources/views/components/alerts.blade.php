@props(['type' => 'info', 'message'])

@php
    $classes = [
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
    ][$type] ?? 'bg-blue-100 border-blue-500 text-blue-700';
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="{{ $classes }} border-l-4 p-4 mb-4"
    role="alert"
>
    <p class="font-bold">{{ ucfirst($type) }}</p>
    <p>{{ $message }}</p>
</div>
