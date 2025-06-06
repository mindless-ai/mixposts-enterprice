@props(['size' => 'md', 'opacity' => 100, 'rounded' => false])

@php
    $sizeClass = [
        'sm' => 'h-4 w-4',
        'md' => 'h-6 w-6',
        'lg' => 'h-8 w-8',
        'xl' => 'h-10 w-10',
    ][$size];

    $opacityClass = [
        100 => 'bg-opacity-100',
        75 => 'bg-opacity-75',
        50 => 'bg-opacity-50',
    ][$opacity];
@endphp

<div {{ $attributes->merge(['class' => "$opacityClass " . ($rounded ? 'rounded-lg' : '') . " absolute flex justify-center items-center left-0 top-0 w-full h-full bg-white transition-opacity ease-in-out duration-200 z-10"]) }}>
    <svg class="{{ $sizeClass }} animate-spin -ml-1 mr-sm text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    {{ $slot }}
</div>
