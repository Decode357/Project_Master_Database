@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out'
            : 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
